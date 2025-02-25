document.addEventListener( 'DOMContentLoaded', () => {
	const subCategoryCategoryMetaboxWrapper = '#p2p-to-pdc-category_to_pdc-subcategory';
	const subCategoryCategoryMetabox = 'div[data-p2p_type="pdc-category_to_pdc-subcategory"]';
	const subCategoryCategoryConnectionTableRow = 'div[data-p2p_type="pdc-category_to_pdc-subcategory"] > table.p2p-connections > tbody > tr';
	const postPublishButton = 'div.edit-post-header__settings > button.editor-post-publish-button__button';

	observeMetaboxChanges( subCategoryCategoryMetabox, subCategoryCategoryMetaboxWrapper, subCategoryCategoryConnectionTableRow, postPublishButton );
	validateConnectionsOnLoad( subCategoryCategoryMetabox, subCategoryCategoryMetaboxWrapper, subCategoryCategoryConnectionTableRow, postPublishButton );
} );

function observeMetaboxChanges( metabox, metaboxWrapper, connectionRow, postPublishButton ) {
	const observer = new MutationObserver( () => {
		validateConnections( { metabox, metaboxWrapper, connectionRow, postPublishButton } );
	} );

	const targetNode = document.querySelector( metabox );
	if ( targetNode ) {
		observer.observe( targetNode, { childList: true, subtree: true } );
	}
}

function validateConnections( { metabox, metaboxWrapper, connectionRow, postPublishButton } ) {
	const connectionExists = document.querySelectorAll( connectionRow ).length === 1;

	toggleMetaboxState( metaboxWrapper, metabox, connectionExists );
	togglePublishButton( connectionExists, postPublishButton );
}

function toggleMetaboxState( metaboxWrapper, metabox, connectionExists ) {
	const wrapper = document.querySelector( metaboxWrapper );
	const createConnectionsElement = document.querySelector( `${ metabox } > div.p2p-create-connections` );
	if ( ! wrapper || ! createConnectionsElement ) return;

	if ( connectionExists ) {
		wrapper.style.border = '';
		createConnectionsElement.classList.add( 'hidden' );
	} else {
		wrapper.style.border = '1px solid red';
		createConnectionsElement.classList.remove( 'hidden' );
	}
}

function togglePublishButton( connectionExists, postPublishButton ) {
	document.querySelector( postPublishButton ).disabled = ! connectionExists;
}

function validateConnectionsOnLoad( metabox, metaboxWrapper, connectionRow, postPublishButton ) {
	setTimeout( () => {
		validateConnections( { metabox, metaboxWrapper, connectionRow, postPublishButton } );
	}, 2000 );
}

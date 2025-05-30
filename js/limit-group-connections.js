document.addEventListener( 'DOMContentLoaded', () => {
	const groupCategoryMetaboxWrapper = '#p2p-to-pdc-category_to_pdc-group';
	const groupSubcategoryMetaboxWrapper = '#p2p-to-pdc-subcategory_to_pdc-group';

	const groupCategoryMetabox = 'div[data-p2p_type="pdc-category_to_pdc-group"]';
	const groupSubcategoryMetabox = 'div[data-p2p_type="pdc-subcategory_to_pdc-group"]';

	const groupCategoryConnectionTableRow = 'div[data-p2p_type="pdc-category_to_pdc-group"] > table.p2p-connections > tbody > tr';
	const groupSubcategoryConnectionTableRow = 'div[data-p2p_type="pdc-subcategory_to_pdc-group"] > table.p2p-connections > tbody > tr';

	const postPublishButton = 'div.edit-post-header__settings > button.editor-post-publish-button__button';

	// Monitor changes to metaboxes
	observeMetaboxChanges( groupCategoryMetabox, groupCategoryMetaboxWrapper, groupCategoryConnectionTableRow, groupSubcategoryConnectionTableRow, postPublishButton );
	observeMetaboxChanges( groupSubcategoryMetabox, groupSubcategoryMetaboxWrapper, groupSubcategoryConnectionTableRow, groupCategoryConnectionTableRow, postPublishButton );

	// Validate connections on page load
	validateConnectionsOnLoad( {
		groupCategoryMetaboxWrapper,
		groupSubcategoryMetaboxWrapper,
		groupCategoryConnectionTableRow,
		groupSubcategoryConnectionTableRow,
		postPublishButton,
	} );
} );

function observeMetaboxChanges( metabox, metaboxWrapper, mainConnectionTableRow, subConnectionTableRow, postPublishButton ) {
	const observer = new MutationObserver( () => {
		validateConnectionState( { metaboxWrapper, mainConnectionTableRow, subConnectionTableRow, postPublishButton } );
	} );

	const targetNode = document.querySelector( metabox );
	if ( targetNode ) {
		observer.observe( targetNode, { childList: true, subtree: true } );
	}
}

function validateConnectionsOnLoad( { groupCategoryMetaboxWrapper, groupSubcategoryMetaboxWrapper, groupCategoryConnectionTableRow, groupSubcategoryConnectionTableRow, postPublishButton } ) {
	setTimeout( () => {
		validateConnectionState( { metaboxWrapper: groupCategoryMetaboxWrapper, mainConnectionTableRow: groupCategoryConnectionTableRow } );
		validateConnectionState( { metaboxWrapper: groupSubcategoryMetaboxWrapper, mainConnectionTableRow: groupSubcategoryConnectionTableRow } );
		validatePublishButtonState( { groupCategoryConnectionTableRow, groupSubcategoryConnectionTableRow, postPublishButton } );
	}, 2000 );
}

function validateConnectionState( { metaboxWrapper, mainConnectionTableRow, subConnectionTableRow, postPublishButton } ) {
	const mainConnectionExists = document.querySelectorAll( mainConnectionTableRow ).length >= 1;

	toggleMetaboxBorder( metaboxWrapper, mainConnectionExists );
	validatePublishButtonState( { groupCategoryConnectionTableRow: mainConnectionTableRow, groupSubcategoryConnectionTableRow: subConnectionTableRow, postPublishButton } );
}

function toggleMetaboxBorder( metaboxWrapper, connectionExists ) {
	const wrapper = document.querySelector( metaboxWrapper );
	if ( ! wrapper ) return;

	wrapper.style.border = connectionExists ? '' : '1px solid red';
}

function validatePublishButtonState( { groupCategoryConnectionTableRow, groupSubcategoryConnectionTableRow, postPublishButton } ) {
	const categoryConnectionExists = document.querySelectorAll( groupCategoryConnectionTableRow ).length >= 1;
	const subcategoryConnectionExists = groupSubcategoryConnectionTableRow ? document.querySelectorAll( groupSubcategoryConnectionTableRow ).length >= 1 : true;

	const button = document.querySelector( postPublishButton );
	if ( ! button ) return;

	button.disabled = ! ( categoryConnectionExists && subcategoryConnectionExists );
}

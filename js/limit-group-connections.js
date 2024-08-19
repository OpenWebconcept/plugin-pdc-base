document.addEventListener('DOMContentLoaded', () => {
    const selectors = {
        groupCategoryMetaboxWrapper: '#p2p-to-pdc-category_to_pdc-group',
        groupSubcategoryMetaboxWrapper: '#p2p-to-pdc-subcategory_to_pdc-group',

        groupCategoryMetabox: 'div[data-p2p_type="pdc-category_to_pdc-group"]',
		groupSubcategoryMetabox: 'div[data-p2p_type="pdc-subcategory_to_pdc-group"]',

        groupCategoryConnectionTableRow: 'div[data-p2p_type="pdc-category_to_pdc-group"] > table.p2p-connections > tbody > tr',
        groupSubcategoryConnectionTableRow: 'div[data-p2p_type="pdc-subcategory_to_pdc-group"] > table.p2p-connections > tbody > tr',

        postPublishButton: 'div.edit-post-header__settings > button.editor-post-publish-button__button',
    };

	const {
        groupCategoryMetaboxWrapper,
        groupSubcategoryMetaboxWrapper,
        groupCategoryMetabox,
        groupSubcategoryMetabox,
        groupCategoryConnectionTableRow,
        groupSubcategoryConnectionTableRow,
        postPublishButton,
    } = selectors;

    // Monitor changes to metaboxes
    observeMetaboxChanges(groupCategoryMetabox, groupCategoryMetaboxWrapper, groupCategoryConnectionTableRow, groupSubcategoryConnectionTableRow, postPublishButton);
    observeMetaboxChanges(groupSubcategoryMetabox, groupSubcategoryMetaboxWrapper, groupSubcategoryConnectionTableRow, groupCategoryConnectionTableRow, postPublishButton);

    // Validate connections on page load
    validateConnectionsOnLoad({
		groupCategoryMetaboxWrapper,
        groupSubcategoryMetaboxWrapper,
        groupCategoryConnectionTableRow,
        groupSubcategoryConnectionTableRow,
        postPublishButton,
    });
});

function observeMetaboxChanges(metabox, metaboxWrapper, mainConnectionTableRow, subConnectionTableRow, postPublishButton) {
    const observer = new MutationObserver(() => {
        validateConnectionState({ metaboxWrapper, mainConnectionTableRow, subConnectionTableRow, postPublishButton });
    });

    const targetNode = document.querySelector(metabox);
    if (targetNode) {
        observer.observe(targetNode, { childList: true, subtree: true });
    }
}

function validateConnectionsOnLoad({ groupCategoryMetaboxWrapper, groupSubcategoryMetaboxWrapper, groupCategoryConnectionTableRow, groupSubcategoryConnectionTableRow,  postPublishButton }) {
    setTimeout(() => {
        validateConnectionState({ metaboxWrapper: groupCategoryMetaboxWrapper, mainConnectionTableRow: groupCategoryConnectionTableRow });
        validateConnectionState({ metaboxWrapper: groupSubcategoryMetaboxWrapper, mainConnectionTableRow: groupSubcategoryConnectionTableRow });
        validatePublishButtonState({ groupCategoryConnectionTableRow, groupSubcategoryConnectionTableRow, postPublishButton });
    }, 1000);
}

function validateConnectionState({ metaboxWrapper, mainConnectionTableRow, subConnectionTableRow, postPublishButton }) {
    const mainConnectionExists = document.querySelectorAll(mainConnectionTableRow).length >= 1;
    const subConnectionExists = subConnectionTableRow ? document.querySelectorAll(subConnectionTableRow).length >= 1 : true;

    toggleMetaboxBorder(metaboxWrapper, mainConnectionExists);
    validatePublishButtonState({ groupCategoryConnectionTableRow: mainConnectionTableRow, groupSubcategoryConnectionTableRow: subConnectionTableRow, postPublishButton });
}

function toggleMetaboxBorder(metaboxWrapper, connectionExists) {
    const wrapper = document.querySelector(metaboxWrapper);
    if (!wrapper) return;

    wrapper.style.border = connectionExists ? '' : '1px solid red';
}

function validatePublishButtonState({ groupCategoryConnectionTableRow, groupSubcategoryConnectionTableRow, postPublishButton }) {
    const categoryConnectionExists = document.querySelectorAll(groupCategoryConnectionTableRow).length >= 1;
    const subcategoryConnectionExists = groupSubcategoryConnectionTableRow ? document.querySelectorAll(groupSubcategoryConnectionTableRow).length >= 1 : true;

    const button = document.querySelector(postPublishButton);
    if (!button) return;

    button.disabled = !(categoryConnectionExists && subcategoryConnectionExists);
}

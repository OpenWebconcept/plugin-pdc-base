document.addEventListener('DOMContentLoaded', () => {
    const selectors = {
        itemCategoryMetaboxWrapper: '#p2p-from-pdc-item_to_pdc-category',
        itemSubcategoryMetaboxWrapper: '#p2p-from-pdc-item_to_pdc-subcategory',
        itemGroupMetaboxWrapper: '#p2p-from-pdc-item_to_pdc-group',
        itemCategoryMetabox: 'div[data-p2p_type="pdc-item_to_pdc-category"]',
        itemSubcategoryMetabox: 'div[data-p2p_type="pdc-item_to_pdc-subcategory"]',
        itemGroupMetabox: 'div[data-p2p_type="pdc-item_to_pdc-group"]',
        itemCategoryConnectionTableRow: 'div[data-p2p_type="pdc-item_to_pdc-category"] > table.p2p-connections > tbody > tr',
        itemSubcategoryConnectionTableRow: 'div[data-p2p_type="pdc-item_to_pdc-subcategory"] > table.p2p-connections > tbody > tr',
        itemGroupConnectionTableRow: 'div[data-p2p_type="pdc-item_to_pdc-group"] > table.p2p-connections > tbody > tr',
        postPublishButton: 'div.edit-post-header__settings > button.editor-post-publish-button__button',
    };

    const {
        itemCategoryMetaboxWrapper,
        itemSubcategoryMetaboxWrapper,
        itemGroupMetaboxWrapper,
        itemCategoryMetabox,
        itemSubcategoryMetabox,
        itemGroupMetabox,
        itemCategoryConnectionTableRow,
        itemSubcategoryConnectionTableRow,
        itemGroupConnectionTableRow,
        postPublishButton,
    } = selectors;

    // Monitor changes to metaboxes
    observeMetaboxChanges(itemCategoryMetabox, itemCategoryMetaboxWrapper, itemCategoryConnectionTableRow, itemSubcategoryConnectionTableRow, postPublishButton);
    observeMetaboxChanges(itemSubcategoryMetabox, itemSubcategoryMetaboxWrapper, itemSubcategoryConnectionTableRow, itemCategoryConnectionTableRow, postPublishButton);
    observeGroupMetaboxChanges(itemGroupMetabox, itemGroupConnectionTableRow);

    // Validate connections on page load
    validateConnectionsOnLoad({
        itemCategoryMetaboxWrapper,
        itemSubcategoryMetaboxWrapper,
        itemGroupMetaboxWrapper,
        itemCategoryConnectionTableRow,
        itemSubcategoryConnectionTableRow,
        itemGroupConnectionTableRow,
        itemGroupMetabox,
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

function observeGroupMetaboxChanges(metabox, mainConnectionTableRow) {
    const observer = new MutationObserver(() => {
        toggleGroupConnectionVisibility(metabox, mainConnectionTableRow);
    });

    const targetNode = document.querySelector(metabox);
    if (targetNode) {
        observer.observe(targetNode, { childList: true, subtree: true });
    }
}

function validateConnectionsOnLoad({ itemCategoryMetaboxWrapper, itemSubcategoryMetaboxWrapper, itemGroupMetaboxWrapper, itemCategoryConnectionTableRow, itemSubcategoryConnectionTableRow, itemGroupConnectionTableRow, itemGroupMetabox, postPublishButton }) {
    setTimeout(() => {
        validateConnectionState({ metaboxWrapper: itemCategoryMetaboxWrapper, mainConnectionTableRow: itemCategoryConnectionTableRow });
        validateConnectionState({ metaboxWrapper: itemSubcategoryMetaboxWrapper, mainConnectionTableRow: itemSubcategoryConnectionTableRow });
        toggleGroupConnectionVisibility(itemGroupMetabox, itemGroupConnectionTableRow);
        validatePublishButtonState({ itemCategoryConnectionTableRow, itemSubcategoryConnectionTableRow, postPublishButton });
    }, 1000);
}

function validateConnectionState({ metaboxWrapper, mainConnectionTableRow, subConnectionTableRow, postPublishButton }) {
    const mainConnectionExists = document.querySelectorAll(mainConnectionTableRow).length >= 1;
    const subConnectionExists = subConnectionTableRow ? document.querySelectorAll(subConnectionTableRow).length >= 1 : true;

    toggleMetaboxBorder(metaboxWrapper, mainConnectionExists);
    validatePublishButtonState({ itemCategoryConnectionTableRow: mainConnectionTableRow, itemSubcategoryConnectionTableRow: subConnectionTableRow, postPublishButton });
}

function toggleMetaboxBorder(metaboxWrapper, connectionExists) {
    const wrapper = document.querySelector(metaboxWrapper);
    if (!wrapper) return;

    wrapper.style.border = connectionExists ? '' : '1px solid red';
}

function toggleGroupConnectionVisibility(metabox, mainConnectionTableRow) {
    const createConnectionsElement = document.querySelector(`${metabox} > div.p2p-create-connections`);
    const connectionExists = document.querySelectorAll(mainConnectionTableRow).length === 1;

    if (!createConnectionsElement) return;

    createConnectionsElement.classList.toggle('hidden', connectionExists);
}

function validatePublishButtonState({ itemCategoryConnectionTableRow, itemSubcategoryConnectionTableRow, postPublishButton }) {
    const categoryConnectionExists = document.querySelectorAll(itemCategoryConnectionTableRow).length >= 1;
    const subcategoryConnectionExists = itemSubcategoryConnectionTableRow ? document.querySelectorAll(itemSubcategoryConnectionTableRow).length >= 1 : true;

    const button = document.querySelector(postPublishButton);
    if (!button) return;

    button.disabled = !(categoryConnectionExists && subcategoryConnectionExists);
}

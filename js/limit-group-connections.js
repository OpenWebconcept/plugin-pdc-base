document.addEventListener('DOMContentLoaded', () => {
    const selectors = {
        groupSubcategoryMetaboxWrapper: '#p2p-to-pdc-subcategory_to_pdc-group',
        groupSubcategoryMetabox: 'div[data-p2p_type="pdc-subcategory_to_pdc-group"]',
        groupSubCategoryConnectionTableRow: 'div[data-p2p_type="pdc-subcategory_to_pdc-group"] > table.p2p-connections > tbody > tr',
        groupItemMetaboxWrapper: '#p2p-to-pdc-item_to_pdc-group',
        groupItemMetabox: 'div[data-p2p_type="pdc-item_to_pdc-group"]',
        groupItemConnectionTableRow: 'div[data-p2p_type="pdc-item_to_pdc-group"] > table.p2p-connections > tbody > tr',
        groupCategoryMetaboxWrapper: '#p2p-to-pdc-category_to_pdc-group',
        groupCategoryMetabox: 'div[data-p2p_type="pdc-category_to_pdc-group"]',
        groupCategoryConnectionTableRow: 'div[data-p2p_type="pdc-category_to_pdc-group"] > table.p2p-connections > tbody > tr',
        postPublishButton: 'div.edit-post-header__settings > button.editor-post-publish-button__button',
    };

    const {
        groupSubcategoryMetabox,
        groupSubcategoryMetaboxWrapper,
        groupSubCategoryConnectionTableRow,
        groupItemMetabox,
        groupItemMetaboxWrapper,
        groupItemConnectionTableRow,
        groupCategoryMetabox,
        groupCategoryMetaboxWrapper,
        groupCategoryConnectionTableRow,
        postPublishButton,
    } = selectors;

    const metaboxes = [
        { metabox: groupSubcategoryMetabox, metaboxWrapper: groupSubcategoryMetaboxWrapper, connectionRow: groupSubCategoryConnectionTableRow },
        { metabox: groupItemMetabox, metaboxWrapper: groupItemMetaboxWrapper, connectionRow: groupItemConnectionTableRow },
        { metabox: groupCategoryMetabox, metaboxWrapper: groupCategoryMetaboxWrapper, connectionRow: groupCategoryConnectionTableRow }
    ];

    metaboxes.forEach(({ metabox, metaboxWrapper, connectionRow }) => {
        observeMetaboxChanges(metabox, metaboxWrapper, connectionRow, postPublishButton);
    });

    validateConnectionsOnLoad(metaboxes, postPublishButton);
});

function observeMetaboxChanges(metabox, metaboxWrapper, connectionRow, postPublishButton) {
    const observer = new MutationObserver(() => {
        validateConnections({ metabox, metaboxWrapper, connectionRow, postPublishButton });
    });

    const config = { childList: true, subtree: true };
    const targetNode = document.querySelector(metabox);
    if (targetNode) {
        observer.observe(targetNode, config);
    }
}

function validateConnections({ metabox, metaboxWrapper, connectionRow, postPublishButton }) {
    const connectionExists = document.querySelectorAll(connectionRow).length > 0;
    toggleMetaboxState(metaboxWrapper, connectionExists);
    togglePublishButton(postPublishButton);
}

function toggleMetaboxState(metaboxWrapper, connectionExists) {
    const wrapper = document.querySelector(metaboxWrapper);
    if (!wrapper) return;

    if (connectionExists) {
        wrapper.style.border = '';
        wrapper.querySelector('.p2p-create-connections')?.classList.add('hidden');
    } else {
        wrapper.style.border = '1px solid red';
        wrapper.querySelector('.p2p-create-connections')?.classList.remove('hidden');
    }
}

function togglePublishButton(postPublishButton) {
    const disable = [...document.querySelectorAll('[data-p2p_type] > table.p2p-connections > tbody > tr')]
        .every(tr => tr.length === 0);

    document.querySelector(postPublishButton).disabled = disable;
}

function validateConnectionsOnLoad(metaboxes, postPublishButton) {
    setTimeout(() => {
        metaboxes.forEach(({ metabox, metaboxWrapper, connectionRow }) => {
            validateConnections({ metabox, metaboxWrapper, connectionRow, postPublishButton });
        });
    }, 1000);
}

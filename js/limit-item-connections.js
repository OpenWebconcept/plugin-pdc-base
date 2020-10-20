/**
 * Validate the PostsToPosts connections for pdc-items.
 */
jQuery(document).ready(function ($) {
    let itemCategoryMetaboxWrapper          = '#p2p-from-pdc-item_to_pdc-category';
    let itemSubcategoryMetaboxWrapper       = '#p2p-from-pdc-item_to_pdc-subcategory';
    let itemCategoryMetabox                 = 'div[data-p2p_type="pdc-item_to_pdc-category"]';
    let itemSubcategoryMetabox              = 'div[data-p2p_type="pdc-item_to_pdc-subcategory"]';
    let itemCategoryConnectionTableRow      = 'div[data-p2p_type="pdc-item_to_pdc-category"] > table.p2p-connections > tbody > tr';
    let itemSubcategoryConnectionTableRow   = 'div[data-p2p_type="pdc-item_to_pdc-subcategory"] > table.p2p-connections > tbody > tr';
    let postPublishButton                   = 'div.edit-post-header__settings > button.editor-post-publish-button__button';
    
    // create a binding for when the metabox changes
    watchMetaboxOnChange(itemCategoryMetabox, itemCategoryMetaboxWrapper, itemCategoryConnectionTableRow, itemSubcategoryConnectionTableRow, postPublishButton, $);
    watchMetaboxOnChange(itemSubcategoryMetabox, itemSubcategoryMetaboxWrapper, itemSubcategoryConnectionTableRow, itemCategoryConnectionTableRow, postPublishButton, $);

    // wait before the dom is loaded
    metaboxValidationAfterPageLoad(
        itemCategoryMetabox, 
        itemSubcategoryMetabox, 
        itemCategoryMetaboxWrapper, 
        itemSubcategoryMetaboxWrapper, 
        itemCategoryConnectionTableRow, 
        itemSubcategoryConnectionTableRow, 
        postPublishButton, 
        $
    );
});

/**
 * Validate the PostsToPosts connections metaboxes after pageload.
 * 
 * @param {string} itemCategoryMetabox 
 * @param {string} itemSubcategoryMetabox 
 * @param {string} itemCategoryMetaboxWrapper 
 * @param {string} itemSubcategoryMetaboxWrapper 
 * @param {string} itemCategoryConnectionTableRow 
 * @param {string} itemSubcategoryConnectionTableRow 
 * @param {string} postPublishButton 
 * @param {Object} $ 
 */
function metaboxValidationAfterPageLoad(
    itemCategoryMetabox, 
    itemSubcategoryMetabox, 
    itemCategoryMetaboxWrapper, 
    itemSubcategoryMetaboxWrapper, 
    itemCategoryConnectionTableRow, 
    itemSubcategoryConnectionTableRow, 
    postPublishButton, 
    $
)
{
    setTimeout(function(){ 
        if($(itemCategoryConnectionTableRow).length >= 1)
        {
            $(itemCategoryMetaboxWrapper).css("border", "");
        }

        if($(itemSubcategoryConnectionTableRow).length >= 1)
        {
            $(itemSubcategoryMetaboxWrapper).css("border", "");
        }

        if($(itemCategoryConnectionTableRow).length == 0)
        {
            $(itemCategoryMetabox + '> div.p2p-create-connections').show();
            $(itemCategoryMetaboxWrapper).css("border", "1px solid red");
        }

        if($(itemSubcategoryConnectionTableRow).length == 0)
        {
            $(itemSubcategoryMetabox + '> div.p2p-create-connections').show();
            $(itemSubcategoryMetaboxWrapper).css("border", "1px solid red");
        }

        if($(itemCategoryConnectionTableRow).length == 0 || $(itemSubcategoryConnectionTableRow).length == 0)
        {
            $(postPublishButton).prop("disabled",true);
        }

        if($(itemCategoryConnectionTableRow).length >= 1 && $(itemSubcategoryConnectionTableRow).length >= 1)
        {
            $(postPublishButton).prop("disabled",false);
        }
    }, 1000);
}

/**
 * Validate the PostsToPosts connections metaboxes on modification.
 * 
 * @param {string} metabox 
 * @param {string} metaboxWrapper 
 * @param {string} mainConnectionTableRow 
 * @param {string} subConnectionTableRow 
 * @param {string} postPublishButton 
 * @param {Object} $ 
 */
function watchMetaboxOnChange(metabox, metaboxWrapper, mainConnectionTableRow, subConnectionTableRow, postPublishButton, $)
{
    $(metabox).bind("DOMSubtreeModified", function() {	
        if($(mainConnectionTableRow).length >= 1)
		{
            $(metaboxWrapper).css("border", "");
        }
        
        if($(mainConnectionTableRow).length == 0)
		{
            $(metabox  + '> div.p2p-create-connections').show();
            $(metaboxWrapper).css("border", "1px solid red");
        }
        
        if($(mainConnectionTableRow).length == 0 || $(subConnectionTableRow).length == 0)
        {
            $(postPublishButton).prop("disabled",true);
        }

        if($(mainConnectionTableRow).length >= 1 && $(subConnectionTableRow).length >= 1)
        {
            $(postPublishButton).prop("disabled",false);
        }
    });
}


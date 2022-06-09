/**
 * Validate the PostsToPosts connections for pdc-items.
 */
jQuery(document).ready(function ($) {
    let subCategoryCategoryMetaboxWrapper       = '#p2p-to-pdc-category_to_pdc-subcategory';
    let subCategoryCategoryMetabox              = 'div[data-p2p_type="pdc-category_to_pdc-subcategory"]';
    let subCategoryCategoryConnectionTableRow   = 'div[data-p2p_type="pdc-category_to_pdc-subcategory"] > table.p2p-connections > tbody > tr';
    let postPublishButton                   = 'div.edit-post-header__settings > button.editor-post-publish-button__button';
    
    // create a binding for when the metabox changes
    watchMetaboxOnChange(subCategoryCategoryMetabox, subCategoryCategoryMetaboxWrapper, subCategoryCategoryConnectionTableRow, postPublishButton, $);

    // wait before the dom is loaded
    metaboxValidationAfterPageLoad(
        subCategoryCategoryMetabox, 
        subCategoryCategoryMetaboxWrapper, 
        subCategoryCategoryConnectionTableRow, 
        postPublishButton, 
        $
    );
});

/**
 * Validate the PostsToPosts connections metaboxes after pageload.
 * 
 * @param {string} subCategoryCategoryMetabox 
 * @param {string} subCategoryCategoryMetaboxWrapper 
 * @param {string} subCategoryCategoryConnectionTableRow 
 * @param {string} postPublishButton 
 * @param {Object} $ 
 */
function metaboxValidationAfterPageLoad(
    subCategoryCategoryMetabox, 
    subCategoryCategoryMetaboxWrapper, 
    subCategoryCategoryConnectionTableRow, 
    postPublishButton, 
    $
)
{
    setTimeout(function(){ 
        if($(subCategoryCategoryConnectionTableRow).length = 1)
        {
            $(postPublishButton).prop("disabled",false);
            $(subCategoryCategoryMetabox + '> div.p2p-create-connections').hide();
            $(subCategoryCategoryMetaboxWrapper).css("border", "");
        }

        if($(subCategoryCategoryConnectionTableRow).length == 0)
        {
            $(postPublishButton).prop("disabled",true);
            $(subCategoryCategoryMetabox + '> div.p2p-create-connections').show();
            $(subCategoryCategoryMetaboxWrapper).css("border", "1px solid red");
        }
    }, 1000);
}

/**
 * Validate the PostsToPosts connections on modification.
 * 
 * @param {string} metabox 
 * @param {string} metaboxWrapper 
 * @param {string} mainConnectionTableRow 
 * @param {string} postPublishButton 
 * @param {Object} $ 
 */
function watchMetaboxOnChange(metabox, metaboxWrapper, mainConnectionTableRow, postPublishButton, $)
{
    $(metabox).bind("DOMSubtreeModified", function() {	
        if($(mainConnectionTableRow).length = 1)
		{
            $(postPublishButton).prop("disabled",false);
            $(metabox + '> div.p2p-create-connections').hide();
            $(metaboxWrapper).css("border", "");
        }
        
        if($(mainConnectionTableRow).length == 0)
		{
            $(postPublishButton).prop("disabled",true);
            $(metabox + '> div.p2p-create-connections').show();
            $(metaboxWrapper).css("border", "1px solid red");
        }
    });
}
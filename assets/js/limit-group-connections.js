/**
 * Validate the PostsToPosts connections for pdc-items.
 */
jQuery(document).ready(function ($) {
    let groupSubcategoryMetaboxWrapper      = '#p2p-to-pdc-subcategory_to_pdc-group';
    let groupSubcategoryMetabox             = 'div[data-p2p_type="pdc-subcategory_to_pdc-group"]';
    let groupSubCategoryConnectionTableRow  = 'div[data-p2p_type="pdc-subcategory_to_pdc-group"] > table.p2p-connections > tbody > tr';
    let groupItemMetaboxWrapper             = '#p2p-to-pdc-item_to_pdc-group';
    let groupItemMetabox                    = 'div[data-p2p_type="pdc-item_to_pdc-group"]';
    let groupItemConnectionTableRow         = 'div[data-p2p_type="pdc-item_to_pdc-group"] > table.p2p-connections > tbody > tr';
    let groupCategoryMetaboxWrapper         = '#p2p-to-pdc-category_to_pdc-group';
    let groupCategoryMetabox                = 'div[data-p2p_type="pdc-category_to_pdc-group"]';
    let groupCategoryConnectionTableRow     = 'div[data-p2p_type="pdc-category_to_pdc-group"] > table.p2p-connections > tbody > tr';
    let postPublishButton                   = 'div.edit-post-header__settings > button.editor-post-publish-button__button';
    
    // create a binding for when the metabox changes
    watchSubcategoryMetaboxOnChange(groupSubcategoryMetabox, groupSubcategoryMetaboxWrapper, groupSubCategoryConnectionTableRow, groupItemConnectionTableRow, groupCategoryConnectionTableRow, postPublishButton, $);
    watchGroupMetaboxOnChange(groupItemMetabox, groupItemMetaboxWrapper, groupItemConnectionTableRow, groupSubCategoryConnectionTableRow, groupCategoryConnectionTableRow, postPublishButton, $);
    watchCategoryMetaboxOnChange(groupCategoryMetabox, groupCategoryMetaboxWrapper, groupCategoryConnectionTableRow, groupSubCategoryConnectionTableRow, groupItemConnectionTableRow, postPublishButton, $);

    // wait before the dom is loaded
    metaboxValidationAfterPageLoad(
        groupSubcategoryMetabox, 
        groupItemMetabox, 
        groupItemMetaboxWrapper, 
        groupSubcategoryMetaboxWrapper, 
        groupItemConnectionTableRow,
        groupSubCategoryConnectionTableRow, 
        groupCategoryMetabox,
        groupCategoryMetaboxWrapper,
        groupCategoryConnectionTableRow,
        postPublishButton, 
        $
    );
});

/**
 * Validate the PostsToPosts connections metaboxes after pageload.
 * 
 * @param {string} groupSubcategoryMetabox 
 * @param {string} groupSubcategoryMetaboxWrapper 
 * @param {string} groupSubCategoryConnectionTableRow 
 * @param {string} postPublishButton 
 * @param {Object} $ 
 */
function metaboxValidationAfterPageLoad(
    groupSubcategoryMetabox, 
    groupItemMetabox, 
    groupItemMetaboxWrapper, 
    groupSubcategoryMetaboxWrapper, 
    groupItemConnectionTableRow,
    groupSubCategoryConnectionTableRow, 
    groupCategoryMetabox,
    groupCategoryMetaboxWrapper,
    groupCategoryConnectionTableRow,
    postPublishButton, 
    $
)
{
    setTimeout(function(){ 
        if($(groupItemConnectionTableRow).length >= 1)
        {
            $(groupItemMetaboxWrapper).css("border", "");
        }

        if($(groupSubCategoryConnectionTableRow).length >= 1)
        {
            $(groupSubcategoryMetaboxWrapper).css("border", "");
        }

        if($(groupCategoryConnectionTableRow).length == 1)
        {
            $(groupCategoryMetabox + '> div.p2p-create-connections').hide();
            $(groupCategoryMetaboxWrapper).css("border", "");
        }

        if($(groupItemConnectionTableRow).length == 0)
        {
            $(groupItemMetabox + '> div.p2p-create-connections').show();
            $(groupItemMetaboxWrapper).css("border", "1px solid red");
        }

        if($(groupSubCategoryConnectionTableRow).length == 0)
        {
            $(groupSubcategoryMetabox + '> div.p2p-create-connections').show();
            $(groupSubcategoryMetaboxWrapper).css("border", "1px solid red");
        }

        if($(groupCategoryConnectionTableRow).length == 0)
        {
            $(groupCategoryMetabox + '> div.p2p-create-connections').show();
            $(groupCategoryMetaboxWrapper).css("border", "1px solid red");
        }

        if($(groupSubCategoryConnectionTableRow).length == 0 || $(groupItemConnectionTableRow).length == 0 || $(groupCategoryConnectionTableRow).length == 0)
        {
            $(postPublishButton).prop("disabled",true);
        }

        if($(groupSubCategoryConnectionTableRow).length >= 1 && $(groupItemConnectionTableRow).length >= 1 && $(groupCategoryConnectionTableRow).length == 1)
        {
            $(postPublishButton).prop("disabled",false);
        }
    }, 1000);
}

/**
 * Validate the PostsToPosts connections on modification.
 * 
 * @param {string} metabox 
 * @param {string} metaboxWrapper 
 * @param {string} primaryConnectionTableRow 
 * @param {string} secondaryConnectionTableRow 
 * @param {string} postPublishButton 
 * @param {Object} $ 
 */
function watchSubcategoryMetaboxOnChange(metabox, metaboxWrapper, primaryConnectionTableRow, secondaryConnectionTableRow, tertiaryConnectionTableRow, postPublishButton, $)
{
    $(metabox).bind("DOMSubtreeModified", function() {	
        if($(primaryConnectionTableRow).length >= 1)
		{
            $(metaboxWrapper).css("border", "");
        }
        
        if($(primaryConnectionTableRow).length == 0)
		{
            $(metabox  + '> div.p2p-create-connections').show();
            $(metaboxWrapper).css("border", "1px solid red");
        }
        
        if($(primaryConnectionTableRow).length == 0 || $(secondaryConnectionTableRow).length == 0 || $(tertiaryConnectionTableRow).length == 0)
        {
            $(postPublishButton).prop("disabled",true);
        }

        if($(primaryConnectionTableRow).length >= 1 && $(secondaryConnectionTableRow).length >= 1 && $(tertiaryConnectionTableRow).length == 1)
        {
            $(postPublishButton).prop("disabled",false);
        }
    });
}

/**
 * Validate the PostsToPosts connections on modification.
 * 
 * @param {string} metabox 
 * @param {string} metaboxWrapper 
 * @param {string} primaryConnectionTableRow 
 * @param {string} secondaryConnectionTableRow 
 * @param {string} postPublishButton 
 * @param {Object} $ 
 */
function watchGroupMetaboxOnChange(metabox, metaboxWrapper, primaryConnectionTableRow, secondaryConnectionTableRow, tertiaryConnectionTableRow, postPublishButton, $)
{
    $(metabox).bind("DOMSubtreeModified", function() {	
        if($(primaryConnectionTableRow).length >= 1)
		{
            $(metaboxWrapper).css("border", "");
        }
        
        if($(primaryConnectionTableRow).length == 0)
		{
            $(metabox  + '> div.p2p-create-connections').show();
            $(metaboxWrapper).css("border", "1px solid red");
        }
        
        if($(primaryConnectionTableRow).length == 0 || $(secondaryConnectionTableRow).length == 0 || $(tertiaryConnectionTableRow).length == 0)
        {
            $(postPublishButton).prop("disabled",true);
        }

        if($(primaryConnectionTableRow).length >= 1 && $(secondaryConnectionTableRow).length >= 1 && $(tertiaryConnectionTableRow).length == 1)
        {
            $(postPublishButton).prop("disabled",false);
        }
    });
}

/**
 * Validate the PostsToPosts connections on modification.
 * 
 * @param {string} metabox 
 * @param {string} metaboxWrapper 
 * @param {string} primaryConnectionTableRow 
 * @param {string} secondaryConnectionTableRow 
 * @param {string} postPublishButton 
 * @param {Object} $ 
 */
function watchCategoryMetaboxOnChange(metabox, metaboxWrapper, primaryConnectionTableRow, secondaryConnectionTableRow, tertiaryConnectionTableRow, postPublishButton, $)
{
    $(metabox).bind("DOMSubtreeModified", function() {	
        if($(primaryConnectionTableRow).length == 1)
		{
            $(metabox  + '> div.p2p-create-connections').hide();
            $(metaboxWrapper).css("border", "");
        }
        
        if($(primaryConnectionTableRow).length == 0)
		{
            $(metabox  + '> div.p2p-create-connections').show();
            $(metaboxWrapper).css("border", "1px solid red");
        }
        
        if($(primaryConnectionTableRow).length == 0 || $(secondaryConnectionTableRow).length == 0 || $(tertiaryConnectionTableRow).length == 0)
        {
            $(postPublishButton).prop("disabled",true);
        }

        if($(primaryConnectionTableRow).length == 1 && $(secondaryConnectionTableRow).length >= 1 && $(tertiaryConnectionTableRow).length >= 1)
        {
            $(postPublishButton).prop("disabled",false);
        }
    });
}
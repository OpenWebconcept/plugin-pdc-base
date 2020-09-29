/**
 * If UPL fields are empty populate them based on post title
 */
jQuery(document).ready(function ($) {
	if (
		$("#_owc_pdc_upl_resource").val().length === 0 &&
		$("#_owc_pdc_upl_naam").val().length === 0
	) {
		$("body").on(
			"DOMSubtreeModified",
			".editor-post-title__input",
			function () {
				title = $(".editor-post-title__input").val();

				if (title.length > 0) {
					title = title.replace(/\s/g, "-");

					$("#_owc_pdc_upl_naam").val(title);
					$("#_owc_pdc_upl_resource").val(
						"http://standaarden.overheid.nl/owms/terms/" +
							title.toLowerCase()
					);
				}
			}
		);
	}
});

/**
 * Core's focusHTMLBookmarkInVisualEditor() (wp-admin/js/editor.js) restores the
 * caret after a Visual/Code switch via selection.select()/setRng(). Meta Box
 * keeps cloneable groups and their clone template in display:none containers,
 * and Firefox returns null from getSelection() for a document without layout,
 * so the restore throws and takes marker cleanup and editor.save() with it.
 * Chromium returns an empty Selection there, hence Firefox-only. Skip the
 * restore when the editor has no layout.
 */
(function () {
	var installed = false;

	function isRendered(editor) {
		try {
			var body = editor.getBody();

			if (!body || !body.getClientRects().length) {
				return false;
			}

			return editor.getWin().getSelection() !== null;
		} catch (e) {
			return false;
		}
	}

	function guard(editor) {
		if (editor.owcSelectionGuarded) {
			return;
		}

		editor.owcSelectionGuarded = true;

		var selection = editor.selection;
		var select = selection.select.bind(selection);
		var setRng = selection.setRng.bind(selection);

		selection.select = function (node, content) {
			return isRendered(editor) ? select(node, content) : node;
		};

		selection.setRng = function (rng, forward) {
			if (isRendered(editor)) {
				setRng(rng, forward);
			}
		};
	}

	function guardOnInit(editor) {
		if (editor.initialized) {
			guard(editor);

			return;
		}

		editor.on('init', function () {
			guard(editor);
		});
	}

	function install() {
		if (installed || !window.tinymce) {
			return;
		}

		installed = true;

		tinymce.on('AddEditor', function (event) {
			guardOnInit(event.editor);
		});

		// Editors already created when this runs.
		(tinymce.editors || []).forEach(guardOnInit);
	}

	// WordPress prints the queued footer scripts before _WP_Editors::editor_js()
	// loads TinyMCE, so window.tinymce is normally still undefined here. Waiting
	// is enough: the guard only has to be in place before a Visual/Code switch,
	// and install() picks up editors that already exist.
	install();

	if (!installed) {
		document.addEventListener('DOMContentLoaded', install);
		window.addEventListener('load', install);
	}
})();

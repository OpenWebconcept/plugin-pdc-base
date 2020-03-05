=== OpenPDC base ===
Contributors: Yard Internet
Requires at least: 4.8
Tested up to: 5.3
Requires PHP: 7.0
Stable tag: 2.2.1

Plugin to add the OpenwebConcept OpenPDC to your project.

It enables the input of PDC (Producten Diensten Catalogus), and adds rest api endpoints.

== Changelog ==

= Version 2.2.1 =
- Fix: URLs with an '&' where wrongly converted to '&#038;'. This is now fixed.
- Chore: add php-cs-fixer for more consistency.

= Version 2.2.0 =
- Fix: use values of FAQ. This fixes an issue if either a question or answer was inserted, but not both. Props @Jasper Heidebrink

# Version 2.1.9 =
- Chore: add option to show connected in rest
- Chore: add query (search) parameters
- Chore: add slug in output
- Chore: fix (sub)theme api
- Chore: add shortcodes for links and downloads
- Chore: allow shortcodes in fields
- Fix: fix recursive merge of args

= Version 2.1.8 =
- Chore: replace docker container with our own for speed optimalisation.
- Chore: add fields parameter for items to select which fields to return. For example: {site}/wp-json/owc/pdc/v1/items?fields=id,downloads will return only the fields id & downloads for all the PDC items.

= Version 2.1.7 =
- Fix: Check if required file for ```is_plugin_active``` is already loaded, otherwise load it.

= Version 2.1.6 =
- Fix: Replace posts-to-posts admin_column with extended post type.

= Version 2.1.5 =
- Add: endpoint description.

 = Version 2.1.4 =
- Add: add order and orderby for themes api.

= Version 2.1.3 =
- Add: search restapi endpoint now uses Elasticsearch with appropriate metafields

= Version 2.1.2 =
- Add filters to admin
- Code cleanup

= Version 2.1.1 =
- Add synonyms to api output

= Version 2.1.0 =
- Add documentation
- Add tests

= Version 2.0.0 =
- Refactor for version 1.0

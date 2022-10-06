# CHANGELOG

## Version 3.4.11 (2022-10-06)

### Refactor

-   Only update UPL resourceURL when uplName meta is updated.

## Version 3.4.10 (2022-08-31)

### Feat

-   Add connected category and subcategory to connected pdc-item.

## Version 3.4.9 (2022-07-29)

### Feat

-   Sort connected items on title in API.

## Version 3.4.8 (2022-07-15)

### Feat

-   Require composer autoload.php when necessary.

## Version 3.4.7 (2022-06-10)

### Feat

-   ID in portal url setting.

## Version 3.4.6 (2022-06-10)

### Refactor

-   Identifications model methods.


## Version 3.4.5 (2022-05-06)

### Feat

-   Add icon field to subtheme.

## Version 3.4.4 (2022-02-04)

### Refactor

-   Generating portal url.

### Fix

-   Return value in filter 'post_type_link' registered in '\OWC\PDC\Base\Admin\AdminServiceProvider::class.

## Version 3.4.3 (2021-11-19)

### Refactor

-   Improve description UPL name metabox.

### Feat

-   Add 'doelgroepen' to overview page of pdc-items with incorrect upl-values.
-   Add missing part of test for action 'rest_prepare_pdc-item' in AdminServiceProviderTest.

## Version 3.4.2 (2021-11-15)

-   UPL pages available with cap 'edit_posts'.

## Version 3.4.1 (2021-11-12)

### Feat

-   Change 'preview' parameter into 'draft-preview'

## Version 3.4.0 (2021-11-09)

### Feat

-   Add autocomplete for upl name.
-   Based on upl name, fetch upl resource url and save as meta.
-   Overview pages of pdc-items with correct and incorrect upl-values.

## Version 3.3.2 (2021-10-28)

### Feat

-   Preview draft without connected posts

## Version 3.3.1 (2021-08-06)

### Fix

-   New draft post portal url

## Version 3.3.0 (2021-08-02)

### Feat

-   Add find by (sub)theme slug in API: `them(a|e)s/{slug}` or `subthem(a|e)s/{slug}`. Thanks @coenjacobs!
-   Add Posts 2 Posts as dependency
-   Some additional code cleanup

## Version 3.2.9

### Feat

-   Ignore p2p on rewrite republish post

## Version 3.2.8

### Fix

-   Extra connected query arguments

## Version 3.2.7

### Fix

-   Register admin serviceproviders

## Version 3.2.6

### Feat

-   Add preview parameter for retrieving drafts
-   Add password parameter for protected posts
-   Purge Varnish on save_post

## Version 3.2.5

### Fix

-   Allow connected items with no type specified

## Version 3.2.4 (2021-06-18)

### Change

-   Add 'custom-fields' to support for the registered posttype.

### Fix

-   Typo in rest output.

## Version 3.2.3

### Feat

-   Allow items with no type specified in the api

## Version 3.2.2

### Feat

-   Allow additional actions before and after the creation of a featured image.

## Version 3.2.1

### Refactor

-   Remove redundant ItemsFields.php files and create one shared file.

## Version 3.2.0

### Feat

-   Internal products need authorization.

## Version 3.1.16

### Feat

-   Add icon field to theme.

## Version 3.1.15

### Feat

-   Add escape element setting to pdc-settings.
-   Add escape element setting in editor of pdc-item.

## Version 3.1.14

### Fix

-   Connection between pdc-item and pdc-group are allowed to be empty.

## Version 3.1.13

### Feat

-   Limit connection between pdc-item and pdc-group to maximum 1

## Version 3.1.12

### Feat

-   Add portal_url to api output
-   Add date_modified to api output

## Version 3.1.11

### Feat

-   Add image to groups in api output

## Version 3.1.10

### Feat

-   Cloneable identification groups
-   Add language meta setting
-   Add language value in api

### Refactor

-   Display identification meta fields, in the editor, when setting has been checked
-   Clean-up

## Version 3.1.9

### Feat

-   Add translations

## Version 3.1.8

### Feat

-   Add order field to identifications

## Version 3.1.7

### Refactor

-   Add default value's to identifications button title and description

## Version 3.1.6

### Fix

-   Multiple connections between group/subthemes, in group editor, on pageload

## Version 3.1.5

### Refactor

-   Allow multiple connections between group/items and group/subthemes in group editor

## Version 3.1.4

### Added

-   Allow multiple themes in connection between pdc-item & themes

## Version 3.1.3

### Added

-   Allow multiple subthemes in connection between pdc-item & subthemes

## Version 3.1.2

### Added

-   General identifications meta fields in editor pdc-items

## Version 3.1.1

### Added

-   Identifications meta fields in editor pdc-items
-   Identifications can be turned on/off via setting
-   Identifications in api results pdc-items endpoint

### Fix

-   Add optional cpt pdc-group

## Version 3.0.1

### Fix

-   Add ID to portal-url if there is no category connected

## Version 3.0.0

### Features:

-   Refactor: clean-up for version 2.0.

### Changed

-   Architecture (Breaking: includes namespaces -> affects pdc-faq, pdc-locations, pdc-samenwerkende-catalogi and pdc-internal-products)

## Version 2.2.13

### Fix:

-   Fix: rest api endpoint /wp-json/owc/pdc/v1/items/internal was not handled correctly is, as `internal` looked like a slug.

## Version 2.2.12

### Fix:

-   Fix: view portal url wp admin bar node

## Version 2.2.11

### Fix:

-   Add valid url to viewnode in adminbar pdc-item

## Version 2.2.10

### Fix:

-   Exclude inactive pdc-items from p2p connected query

## Version 2.2.8

### Fix:

-   Autoloader was not correctly configured, when installing the plugin manually.

## Version 2.2.7

### Fix:

-   Regex for find by slug in rest api was too greedy. Now only a slug is matched, not a string with a '/'.

## Version 2.2.6

### Features:

-   dynamically populate upl

### Fix:

-   replace legacy autoloader
-   php-cs-fixer
-   update mockery/mockery fixes tests
-   phpstan static code analysis

## Version 2.2.5

### Features:

-   Switch php_codesniffer for phpcs
-   Use Yard Digital Agency where appropriate

### Tasks:

-   Run phpcs

### Fix:

-   Link shortcode url now overrides Link URL

## Version 2.2.4

### Features:

-   Add route for single pdc by slug

## Version 2.2.3

### Features:

-   Add images to themes and subthemes

## Version 2.2.2

### Features:

-   Add file size to forms and downloads

## Version 2.2.1

### Features:

-   Make posttype available in rest api

## Version 2.2.0

### Fix:

-   Use values of FAQ. This fixes an issue if either a question or answer was inserted, but not both. Props @Jasper Heidebrink

## Version 2.1.9

### Features:

-   Add option to show connected in rest
-   Add query (search) parameters
-   Add slug in output
-   Fix (sub)theme api
-   Add shortcodes for links and downloads
-   Allow shortcodes in fields

### Fix:

-   Fix recursive merge of args

## Version 2.1.8

### Fix:

-   replace docker container with our own for speed optimalisation.
-   add fields parameter for items to select which fields to return. For example: {site}/wp-json/owc/pdc/v1/items?fields=id,downloads will return only the fields id & downloads for all the PDC items.

## Version 2.1.7

### Fix:

-   (fix): check if required file for `is_plugin_active` is already loaded, otherwise load it.

## Version 2.1.6

### Features:

-   Fix: Replace posts-to-posts admin_column with extended post type.

## Version 2.1.5

### Features:

-   Add: endpoint description.

## Version 2.1.4

### Features:

-   Add: add order and orderby for themes api.

## Version 2.1.3

### Features:

-   Add: search restapi endpoint now uses Elasticsearch with appropriate metafields

## Version 2.1.2

### Features:

-   Add filters to admin

### Fixes:

-   Code cleanup

## Version 2.1.1

### Features:

-   Add synonyms to api output

## Version 2.1.0

### Features:

-   Add documentation
-   Add tests

## Version 2.0.0

### Features:

-   Refactor for version 1.0

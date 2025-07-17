# CHANGELOG

## ## Version [x.y.z] (X)

### Feat

#### Meta Box AIO Support
- **Added**: Support for Meta Box AIO (premium version) alongside the free Meta Box plugin
- **Enhanced**: Dependency checking now recognizes multiple plugin alternatives for better compatibility  
- **Improved**: Admin notices now reflect both free and premium Meta Box options
- **Technical**: Extended `DependencyChecker` class to support `alternatives` array in dependency definitions
- **Backward Compatible**: Existing installations continue to work without changes


## Version [3.15.8] (2025-07-16)

### Feat

- add author id in API response of items/subthemes/themes endpoints

## Version [3.15.7] (2025-06-19)

### Fix

- Formatting portal url based on partial or broken connections

## Version [3.15.6] (2025-05-22)

### Refactor

- Add order_by and order query args to getItems query in ItemController

## Version [3.15.5] (2025-04-23)

### Feat

- Add filter before registering extended taxonomies
- Add filter before registering extended posttypes

## Version [3.15.4] (2025-04-15)

### Feat

- In rest api add filter before applying the_content

## Version [3.15.3] (2025-03-26)

### Fix

- Autoloader

## Version [3.15.2] (2025-03-18)

### Feat

- Make sure the correct portal url is used when filtering on source (i.e. through the REST API) @richardkorthuis (#45)

## Version [3.15.1] (2025-03-14)

### Fix

- Ensure config defaults to empty array when null @rmpel (#44)

## Version [3.15.0] (2025-03-13)

### Feat

- Update extended-cpts and php-cs-fixer
- Apply posttype and taxonomy argument filters
- Apply upl wp_query args
- Show error when p2p_type function does not exist

### Fix

- Extended cpt depency check
- Add meta-box-group as dependency
- UPL admin url

## Version [3.14.1] (2025-03-12)

### Fix

- Cast services var to an array when it is not

## Version [3.14.0] (2025-03-11)

### Feat

- Add postdata to transform function and add portal_url to SettingsController

## Version [3.13.6] (2025-03-11)

### Chore

- Add publiccode.yaml

### Fix

- Return type did not match with output
- Translations just in time error

## Version [3.13.5] (2025-02-17)

### Chore

- Update language files

### Feat

- Add last modified sortable column
- Add translations workflow to plugin-pdc-base

## Version [3.13.4] (2025-02-08)

### Feat

- Add settings API endpoint. @richardkorthuis (#38)

## Version [3.13.3] (2025-02-07)

### Feat

- Replace get_headers with CURL. @Robbert-Imhof (#37)

## Version [3.13.2] (2025-01-29)

### Fix

- Fatal error "non-static method OWC\PDC\Base\Taxonomy\TaxonomyController::addShowOnExplanation() cannot be called statically. @richardkorthuis (#36)

## Version [3.13.1] (2025-01-20)

### Fix

- Correctly extract URLs from shortcodes in 'links' field of pdc-item for REST API.

## Version [3.13.0] (2024-09-30)

### Feat

- Theme tiles, enabled by setting.
- PDC item table of contents, enabled by setting.

## Version [3.12.2] (2024-08-19)

### Refactor

- Validation JavaScript of the post 2 post connections.

## Version [3.12.1] (2024-06-20)

### Feat

- Get all connected items in API response instead of the default 10.

## Version [3.12] (2024-03-14)

### Feat

- Support extra default taxonomy filter options in items endpoint.

## Version [3.11.1] (2024-02-19)

### Feat

- Add show_in_rest arg to all taxonomies.

## Version [3.11] (2024-01-23)

### Fix

- Try catch around get_headers inside CreatesFields class.

## Version [3.10] (2024-01-10)

### Feat

- Enable filtering the items of categories and sub-categories by language.
- Add the language of connected PDC items in the API response data.

## Version [3.9.1] (2024-01-02)

### Refactor

- Remove strtolower check when validating value of UniformeProductnaam.
- Remove conversion to lowercase of meta '_owc_pdc_upl_naam' when validating the values.

## Version [3.9] (2023-10-27)

### Feat

- When the portal URL setting does not contains a valid URL, use URL from connected term of taxonomy 'pdc-show-on'.

## Version [3.8.6] (2023-09-27)

### Feat

- Add 'Polish' and 'Romanian' as selectable languages.

## Version [3.8.5] (2023-09-27)

### Feat

- Validate URL used in getHeaders() method, inside CreatesFields class, with wp_http_validate_url().

## Version [3.8.4] (2023-09-11)

### Refactor

- Metabox title of pdc-category and sub-category.

## Version [3.8.3] (2023-09-11)

### Feat

- Use feedback form setting.

## Version [3.8.2] (2023-08-30)

### Refactor

- Metaboxes from type text to url, when applicable.

## Version [3.8.1] (2023-08-24)

### Refactor

- PHP CS Fixer + run formatting
- Use PSR12 and order imports by length

## Version [3.8.0] (2023-08-21)

### Feat

- Add 'date_modified' to theme endpoints
- Add 'yoast' to theme endpoints

## Version [3.7.12] (2023-08-18)

### Feat

- Use transients in getHeaders() method inside CreatesFields class.

## Version [3.7.11] (2023-06-21)

### Refactor

- Clean-up code.
- Handle content-length header when is array.

### Fix

- Typo in translations.

## Version [3.7.10] (2023-06-16)

### Fix

- DownloadsField RestAPI filesize of external file.

## Version [3.7.9] (2023-05-26)

### Refactor

- Always return date_modified in api.

## Version [3.7.8] (2023-05-15)

### Feat

- Only authenticated users should be able to view 'draft' and 'future' pdc-items.

## Version [3.7.7] (2023-05-15)

### Fix

- Only remove combined identifications when regular identifications are activated.

## Version [3.7.6] (2023-05-15)

### Fix

- Translations.

## Version [3.7.5] (2023-05-12)

### Feat

- Add combined identification field (DigiD and eHerkenning).

## Version [3.7.4] (2023-05-01)

### Refactor

- Remove duplicated code inside UPLResourceHandler.

## Version [3.7.3] (2023-04-28)

### Feat

- Use 'rest_after_insert_pdc-item' filter in addition to existing 'updated_post_meta' filter.

## Version [3.7.2] (2023-04-11)

### Feat

- Filtering sources allows "Show On" feature

## Version [3.7.1] (2023-04-06)

### Refactor

- checkForUpdate must only be executed when current class is not a child.

## Version [3.7.0] (2023-03-06)

### Feat

- Updates can now be provided through the Admin interface.

## Version [3.6.4] (2023-02-09)

### Fix

- Restore current blog when creation of featured image went wrong (network media library)

## Version [3.6.3] (2023-01-11)

### Feat

- Allow querying draft and future (sub)themes

## Version [3.6.2] (2022-12-23)

### Feat

- Extra set up documentation in case plugins are missing

## Version [3.6.1] (2022-12-23)

### Feat

- Include scheduled posts in preview

## Version [3.6.0] (2022-12-19)

### Feat

- Support php8 + update deps

## Version 3.5.0 (2022-12-12)

### Feat

- Include SEO meta fields, provided by multiple plugins, in API.

## Version 3.4.11 (2022-10-06)

### Refactor

- Only update UPL resourceURL when uplName meta is updated.

## Version 3.4.10 (2022-08-31)

### Feat

- Add connected category and subcategory to connected pdc-item.

## Version 3.4.9 (2022-07-29)

### Feat

- Sort connected items on title in API.

## Version 3.4.8 (2022-07-15)

### Feat

- Require composer autoload.php when necessary.

## Version 3.4.7 (2022-06-10)

### Feat

- ID in portal url setting.

## Version 3.4.6 (2022-06-10)

### Refactor

- Identifications model methods.

## Version 3.4.5 (2022-05-06)

### Feat

- Add icon field to subtheme.

## Version 3.4.4 (2022-02-04)

### Refactor

- Generating portal url.

### Fix

- Return value in filter 'post_type_link' registered in '\OWC\PDC\Base\Admin\AdminServiceProvider::class.

## Version 3.4.3 (2021-11-19)

### Refactor

- Improve description UPL name metabox.

### Feat

- Add 'doelgroepen' to overview page of pdc-items with incorrect upl-values.
- Add missing part of test for action 'rest_prepare_pdc-item' in AdminServiceProviderTest.

## Version 3.4.2 (2021-11-15)

- UPL pages available with cap 'edit_posts'.

## Version 3.4.1 (2021-11-12)

### Feat

- Change 'preview' parameter into 'draft-preview'

## Version 3.4.0 (2021-11-09)

### Feat

- Add autocomplete for upl name.
- Based on upl name, fetch upl resource url and save as meta.
- Overview pages of pdc-items with correct and incorrect upl-values.

## Version 3.3.2 (2021-10-28)

### Feat

- Preview draft without connected posts

## Version 3.3.1 (2021-08-06)

### Fix

- New draft post portal url

## Version 3.3.0 (2021-08-02)

### Feat

- Add find by (sub)theme slug in API: `them(a|e)s/{slug}` or `subthem(a|e)s/{slug}`. Thanks @coenjacobs!
- Add Posts 2 Posts as dependency
- Some additional code cleanup

## Version 3.2.9

### Feat

- Ignore p2p on rewrite republish post

## Version 3.2.8

### Fix

- Extra connected query arguments

## Version 3.2.7

### Fix

- Register admin serviceproviders

## Version 3.2.6

### Feat

- Add preview parameter for retrieving drafts
- Add password parameter for protected posts
- Purge Varnish on save_post

## Version 3.2.5

### Fix

- Allow connected items with no type specified

## Version 3.2.4 (2021-06-18)

### Change

- Add 'custom-fields' to support for the registered posttype.

### Fix

- Typo in rest output.

## Version 3.2.3

### Feat

- Allow items with no type specified in the api

## Version 3.2.2

### Feat

- Allow additional actions before and after the creation of a featured image.

## Version 3.2.1

### Refactor

- Remove redundant ItemsFields.php files and create one shared file.

## Version 3.2.0

### Feat

- Internal products need authorization.

## Version 3.1.16

### Feat

- Add icon field to theme.

## Version 3.1.15

### Feat

- Add escape element setting to pdc-settings.
- Add escape element setting in editor of pdc-item.

## Version 3.1.14

### Fix

- Connection between pdc-item and pdc-group are allowed to be empty.

## Version 3.1.13

### Feat

- Limit connection between pdc-item and pdc-group to maximum 1

## Version 3.1.12

### Feat

- Add portal_url to api output
- Add date_modified to api output

## Version 3.1.11

### Feat

- Add image to groups in api output

## Version 3.1.10

### Feat

- Cloneable identification groups
- Add language meta setting
- Add language value in api

### Refactor

- Display identification meta fields, in the editor, when setting has been checked
- Clean-up

## Version 3.1.9

### Feat

- Add translations

## Version 3.1.8

### Feat

- Add order field to identifications

## Version 3.1.7

### Refactor

- Add default value's to identifications button title and description

## Version 3.1.6

### Fix

- Multiple connections between group/subthemes, in group editor, on pageload

## Version 3.1.5

### Refactor

- Allow multiple connections between group/items and group/subthemes in group editor

## Version 3.1.4

### Added

- Allow multiple themes in connection between pdc-item & themes

## Version 3.1.3

### Added

- Allow multiple subthemes in connection between pdc-item & subthemes

## Version 3.1.2

### Added

- General identifications meta fields in editor pdc-items

## Version 3.1.1

### Added

- Identifications meta fields in editor pdc-items
- Identifications can be turned on/off via setting
- Identifications in api results pdc-items endpoint

### Fix

- Add optional cpt pdc-group

## Version 3.0.1

### Fix

- Add ID to portal-url if there is no category connected

## Version 3.0.0

### Features

- Refactor: clean-up for version 2.0.

### Changed

- Architecture (Breaking: includes namespaces -> affects pdc-faq, pdc-locations, pdc-samenwerkende-catalogi and pdc-internal-products)

## Version 2.2.13

### Fix

- Fix: rest api endpoint /wp-json/owc/pdc/v1/items/internal was not handled correctly is, as `internal` looked like a slug.

## Version 2.2.12

### Fix

- Fix: view portal url wp admin bar node

## Version 2.2.11

### Fix

- Add valid url to viewnode in adminbar pdc-item

## Version 2.2.10

### Fix

- Exclude inactive pdc-items from p2p connected query

## Version 2.2.8

### Fix

- Autoloader was not correctly configured, when installing the plugin manually.

## Version 2.2.7

### Fix

- Regex for find by slug in rest api was too greedy. Now only a slug is matched, not a string with a '/'.

## Version 2.2.6

### Features

- dynamically populate upl

### Fix

- replace legacy autoloader
- php-cs-fixer
- update mockery/mockery fixes tests
- phpstan static code analysis

## Version 2.2.5

### Features

- Switch php_codesniffer for phpcs
- Use Yard Digital Agency where appropriate

### Tasks

- Run phpcs

### Fix

- Link shortcode url now overrides Link URL

## Version 2.2.4

### Features

- Add route for single pdc by slug

## Version 2.2.3

### Features

- Add images to themes and subthemes

## Version 2.2.2

### Features

- Add file size to forms and downloads

## Version 2.2.1

### Features

- Make posttype available in rest api

## Version 2.2.0

### Fix

- Use values of FAQ. This fixes an issue if either a question or answer was inserted, but not both. Props @Jasper Heidebrink

## Version 2.1.9

### Features

- Add option to show connected in rest
- Add query (search) parameters
- Add slug in output
- Fix (sub)theme api
- Add shortcodes for links and downloads
- Allow shortcodes in fields

### Fix

- Fix recursive merge of args

## Version 2.1.8

### Fix

- replace docker container with our own for speed optimalisation.
- add fields parameter for items to select which fields to return. For example: {site}/wp-json/owc/pdc/v1/items?fields=id,downloads will return only the fields id & downloads for all the PDC items.

## Version 2.1.7

### Fix

- (fix): check if required file for `is_plugin_active` is already loaded, otherwise load it.

## Version 2.1.6

### Features

- Fix: Replace posts-to-posts admin_column with extended post type.

## Version 2.1.5

### Features

- Add: endpoint description.

## Version 2.1.4

### Features

- Add: add order and orderby for themes api.

## Version 2.1.3

### Features

- Add: search restapi endpoint now uses Elasticsearch with appropriate metafields

## Version 2.1.2

### Features

- Add filters to admin

### Fixes

- Code cleanup

## Version 2.1.1

### Features

- Add synonyms to api output

## Version 2.1.0

### Features

- Add documentation
- Add tests

## Version 2.0.0

### Features

- Refactor for version 1.0

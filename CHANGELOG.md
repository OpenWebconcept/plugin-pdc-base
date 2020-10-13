# CHANGELOG

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

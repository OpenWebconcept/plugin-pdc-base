# CHANGELOG

## Version 2.1.8
### Fix:
* (chore): replace docker container with our own for speed optimalisation.
* (chore): add fields parameter for items to select which fields to return. For example: {site}/wp-json/owc/pdc/v1/items?fields=id,downloads will return only the fields id & downloads for all the PDC items.

## Version 2.1.7
### Fix:
* (fix): check if required file for ```is_plugin_active``` is already loaded, otherwise load it.

## Version 2.1.6
### Features:
* Fix: Replace posts-to-posts admin_column with extended post type.

## Version 2.1.5
### Features:
* Add: endpoint description.

## Version 2.1.4
### Features:
* Add: add order and orderby for themes api.

## Version 2.1.3
### Features:
* Add: search restapi endpoint now uses Elasticsearch with appropriate metafields

## Version 2.1.2
### Features:
* Add filters to admin

### Fixes:
* Code cleanup

## Version 2.1.1
### Features:
* Add synonyms to api output

## Version 2.1.0
### Features:
* Add documentation
* Add tests

## Version 2.0.0
### Features:
* Refactor for version 1.0

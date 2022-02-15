# Hooks

There are various [hooks](https://codex.wordpress.org/Plugin_API/Hooks), which allows for changing the output.

## Action for changing main Plugin object

```php
owc/pdc-base/plugin
```

See OWC\PDC\Base\Foundataion\Config->set method for a way to change this plugins config.

Via the plugin object the following config settings can be adjusted

- metaboxes
- p2p_connections
- posttypes
- rest_api_fields
- settings
- settings_pages
- taxonomies

## Filters the Posts to Posts connection defaults

```php
owc/pdc-base/p2p-connection-defaults
```

## Filters the per Posts to Posts connection, connection type args

```php
owc/pdc-base/before-register-p2p-connection/{$posttypes_from}/{$posttypes_to]}
```

## Filters the data retrieved for links Rest API field

```php
owc/pdc-base/rest-api/pdcitem/field/get-links
```

## Filters the data retrieved for forms Rest API field

```php
owc/pdc-base/rest-api/pdcitem/field/get-forms
```

## Filters the data retrieved for downloads Rest API field

```php
owc/pdc-base/rest-api/pdcitem/field/get-downloads
```

## Filters the data retrieved for alternative title Rest API field

```php
owc/pdc-base/rest-api/pdcitem/field/get-title-alternative
```

## Filters the data retrieved for appointment Rest API field

```php
owc/pdc-base/rest-api/pdcitem/field/get-appointment
```

## Filters the data retrieved for featured image Rest API field

```php
owc/pdc-base/rest-api/pdcitem/field/get-featured_image
```

## Filters the data retrieved for taxonomies Rest API field

```php
owc/pdc-base/rest-api/pdcitem/field/get-taxonomies
owc/pdc-base/core/posttype/posttypes/pdc_item/get-taxonomies/taxonomy-ids
```

## Filters the data retrieved for connections Rest API field

```php
owc/pdc-base/rest-api/pdcitem/field/get-connections
```

## Filters the data retrieved for `has-report` Rest API field

```php
owc/pdc-base/rest-api/pdcsubcategory/field/has-report
```

## Filters the data retrieved for `has-appointment` Rest API field

```php
owc/pdc-base/rest-api/pdcsubcategory/field/has-appointment
```

## Filters the metaboxes to be registered just before registration

```php
owc/pdc-base/before-register-metaboxes
```

## Filters the settings to be registered just before registration

```php
owc/pdc-base/before-register-settings
```

## Allow additional actions before and after the creation of a featured image

```php
owc/pdc-base/rest-api/shared-items/field/before-creation-featured-image
owc/pdc-base/rest-api/shared-items/field/after-creation-featured-image
```

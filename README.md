# README #

This README documents whatever steps are necessary to get this plugin up and running.

### How do I get set up? ###
     
* Unzip and/or move all files to the /wp-content/plugins/pdc-base directory
* Log into WordPress admin and activate the ‘PDC Base’ plugin through the ‘Plugins’ menu
* Go to the 'PDC instellingen pagina' in the left-hand menu to enter some of the required settings

### Filters

There are various [hooks](https://codex.wordpress.org/Plugin_API/Hooks), which allows for changing the output.

##### Filters the Metaboxes config array.
```php
owc/pdc-base/config/metaboxes
```
##### Filters the Posts to Posts config array.
```php
owc/pdc-base/config/p2p_connections
```

##### Filters the Posttypes config array.
```php
owc/pdc-base/config/posttypes
```

##### Filters the Rest API config array.
```php
owc/pdc-base/config/rest_api_fields
```

##### Filters the Settings config array.
```php
owc/pdc-base/config/settings
```

##### Filters the Settings pages config array.
```php
owc/pdc-base/config/settings_pages
```

##### Filters the Taxonomies config array.
```php
owc/pdc-base/config/taxonomies
```

##### Filters the Posts to Posts connection defaults.
```php
owc/pdc-base/p2p-connection-defaults
```

##### Filters the per Posts to Posts connection, connection type args.
```php
owc/pdc-base/before-register-p2p-connection/{$posttypes_from}/{$posttypes_to]}
```

##### Filters the data retrieved for this Rest API field.
```php
owc/pdc-base/rest-api/pdcitem/field/get-links
```

##### Filters the data retrieved for this Rest API field.
```php
owc/pdc-base/rest-api/pdcitem/field/get-forms
```

##### Filters the data retrieved for this Rest API field.
```php
owc/pdc-base/rest-api/pdcitem/field/get-downloads
```

##### Filters the data retrieved for this Rest API field.
```php
owc/pdc-base/rest-api/pdcitem/field/get-title-alternative
```

##### Filters the data retrieved for this Rest API field.
```php
owc/pdc-base/rest-api/pdcitem/field/get-appointment
```

##### Filters the data retrieved for this Rest API field.
```php
owc/pdc-base/rest-api/pdcitem/field/get-featured_image
```

##### Filters the data retrieved for this Rest API field.
```php
owc/pdc-base/rest-api/pdcitem/field/get-taxonomies
owc/pdc-base/core/posttype/posttypes/pdc_item/get-taxonomies/taxonomy-ids
```

##### Filters the data retrieved for this Rest API field.
```php
owc/pdc-base/rest-api/pdcitem/field/get-connections
```

##### Filters the data retrieved for this Rest API field.
```php
owc/pdc-base/rest-api/pdcsubcategory/field/has-report
```

##### Filters the data retrieved for this Rest API field.
```php
owc/pdc-base/rest-api/pdcsubcategory/field/has-appointment
```

##### Filters the metaboxes to be registered just before registration.
```php
owc/pdc-base/before-register-metaboxes
```

##### Filters the settings to be registered just before registration..
```php
owc/pdc-base/before-register-settings
```

### Running tests ###
To run the Unit tests go to a command-line.
```bash
cd /path/to/wordpress/htdocs/wp-content/plugins/pdc-base/
composer install
phpunit
```

For code coverage report, generate report with command line command and view results with browser.
```bash
phpunit --coverage-html ./tests/coverage
```

### Contribution guidelines ###

##### Writing tests
Have a look at the code coverage reports to see where more coverage can be obtained. 
Write tests
Create a Pull request to the OWC repository

### Who do I talk to? ###

IF you have questions about or suggestions for this plugin, please contact <a src="mailto:hpeters@Buren.nl">Holger Peters</a> from Gemeente Buren.

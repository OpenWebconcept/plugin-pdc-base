# README #

This README documents whatever steps are necessary to get this plugin up and running.

### How do I get set up? ###
     
* Unzip and/or move all files to the /wp-content/plugins/pdc-base directory
* Log into WordPress admin and activate the ‘PDC Base’ plugin through the ‘Plugins’ menu
* Go to the 'PDC instellingen pagina' in the left-hand menu to enter some of the required settings

### Plugin actions/filters ###

*   **owc/pdc_base/config/metaboxes**  
Filter to change
owc/pdc_base/before_register_metaboxes


owc/pdc_base/p2p_connection_defaults
owc/pdc_base/config/p2p_posttypes_info
owc/pdc_base/config/p2p_connections
owc/pdc_base/before_register_p2p_connection/{$posttypes_from}/{$posttypes_to]}


owc/pdc_base/config/posttypes
owc/pdc_base/config/rest_api_fields_per_posttype

owc/pdc_base/config/settings
owc/pdc_base/config/settings_pages
owc/pdc_base/before_register_settings


owc/pdc_base/config/taxonomies

owc/pdc_base/core/posttype/posttypes/pdc_item/get_taxonomies/taxonomy_ids

owc/pdc_base/rest_api/pdcitem/field/get_links

### Running tests ###



### Contribution guidelines ###

* Writing tests
* Code review
* Other guidelines

### Who do I talk to? ###

* IF you have questions about or suggestions for this plugin, please contact Holger Peters from Gemeente Buren.
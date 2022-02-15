# Yard | OpenPDC base

Plugin to add the Yard | OpenPDC to your project.

* Contributors: Yard | Digital Agency
* Requires at least: 4.8
* Tested up to: 5.9.0
* Requires PHP: 7.2
* Stable tag: 3.5.0

## Changelog

See [CHANGELOG](CHANGELOG.md).

## Installation

* Recommended way of installation is with [Composer](https://getcomposer.org/):

    You can install the package via composer.
    First, add the the Bitbucket repository to your `composer.json` file.

    ```bash
    "repositories": [
        {
        "type": "vcs",
        "url": "git@bitbucket.org:openwebconcept/plugin-pdc-base.git"
        }
    ]
    ```

    Then, from the command-line, execute the following command:

    ```bash
    composer require plugin/pdc-base
    ```

* If you do not want to or can use composer:

    1. Unzip and/or move all files to the /wp-content/plugins/pdc-base directory
    2. Log into WordPress admin and activate the `PDC Base` plugin through the `Plugins` menu
    3. The plugin will show what other dependencies are required. Install thoses too.
    4. Go to the 'PDC instellingen pagina' in the left-hand menu to enter some of the required settings

## Usage

On the 'PDC instellingen pagina' there are 2 settings optional for extending the slug used in the 'view in portal' url.
The 'view in portal' button can be found in de wp-admin bar on the editor pages of the pdc-items or inside the 'quick edit' blocks on the overview page of pdc-items.
With these optional settings the theme and subtheme can be included into the 'view in portal' url.

Additionally, there is a possibility to use a fourth layer called 'pdc-groups'. The hierarchy, when the fourth layer setting is checked, is pdc-theme -> pdc-subtheme -> pdc-group -> pdc-item.

Finally, pdc-items can support multiple identifications for scheduling an appointment. Currently there are meta settings for DigiD, eHerkenning and eIDAS. You can set those values in the editor of a pdc-item.

### Connections

See [Connections](/docs/connections.md).

### Hooks

See [Hooks](/docs/hooks.md).

### Translations

See [Translations](/docs/translations.md).

### Running tests

To run the Unit tests go to a command-line.

```bash
cd /path/to/wordpress/htdocs/wp-content/plugins/pdc-base/
composer install
composer unit
```

For code coverage report, generate report with command line command and view results with browser.

```bash
composer unit-coverage
```

### Contribution guidelines

#### Writing tests

Have a look at the code coverage reports to see where more coverage can be obtained.
Write tests.
Create a Pull request to the OWC repository.

#### Who do I talk to?

IF you have questions about or suggestions for this plugin, please contact [Holger Peters](mailto:hpeters@buren.nl) from Gemeente Buren.

# prestashop_custom_module

Pass PHP values to TPL and JavaScript files

## Install

- Zip the repo folder
- Add new module via PrestaShop admin and use the zip file

## Usage

Once installed and activated, edit the PHP file to pass the variables you want to access from TPL or JavaScript.

To acces the variables :
- in TPL use e.g.: `{$modules.lci_custom_module.your_variable}`
- in Javascript use e.g.: `prestashop.modules.lci_custom_module.your_variable`
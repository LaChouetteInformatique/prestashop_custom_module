<?php
/**
 * Pass PHP values to TPL and JavaScript files
 *
 * ***************************
 * To acces the variables :
 * - in TPL use e.g.: {$modules.lci_custom_module.your_variable}
 * - in Javascript use e.g.: prestashop.modules.lci_custom_module.your_variable
 * 
 * ***************************
 *
 * @author    Damien BECHERINI <contact@lachouetteinformatique.fr>
 * @copyright CC0 1.0 universel - Public Domain Dedication
 *
 */

class LCI_custom_module extends Module
{
    public function __construct()
	{
		$this->name = 'lci_custom_module';
		$this->version = '1.0.0';
		$this->author = 'LaChouetteInformatique';
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('LCI Custom Module');
		$this->description = $this->l('Permet d\'accéder à certaines variables PHP depuis les fichiers template de PrestaShop, ainsi que dans le code Javascript');
		$this->ps_versions_compliance = array('min' => '1.7.0.0', 'max' => '1.7.99.999');
	}

    public function install()
    {
        return parent::install() && $this->registerHook('actionFrontControllerSetVariables');
    }

    public function hookActionFrontControllerSetVariables()
    {
        $context = Context::getContext();

        // Récupérer la catégorie parente
        $rootCategory = Category::getRootCategory();

        // Récupérer les catégories enfants de premier niveau
        $product_categories = $rootCategory->getChildren(2,1,true,false);

        $prod_cat = [];

        // Récupérer les informations des catégories dans un tableau et ajouter pour chaque catégorie un lien vers son image de catégorie
        foreach ( $product_categories as $key => $category){

            $temp = Category::getNestedCategories($category['id_category']);

            $prod_cat[$key] = array_shift($temp);
            
            // Ajout du lien vers l'image de la catégorie
            // getCatImageLink($name, $id_category, $type = null)
            $prod_cat[$key]['image'] = $context->link->getCatImageLink($category['link_rewrite'], $category['id_category']);
        }

        // https://github.com/PrestaShop/PrestaShop/blob/develop/classes/Manufacturer.php

        // $manufacturers = Manufacturer::getManufacturers(false, 0, true, false, false, true, true);
        // get image type
        // $imagetype = ImageType::getImagesTypes('manufacturers');
        //$this->context->link->getManufacturerImageLink(102, 'medium_default')

        // $stores = Store::getStores($this->context->language->id);

        return [
            'slides_count' => ceil(count(array_keys($prod_cat))/4),
            'indexes' => array_keys($prod_cat),
            'categories' => $prod_cat,
            'category_carousel_template_dir' => _PS_THEME_DIR_.'/templates/categories_carousel.tpl',
            // 'manufacturers' => $manufacturers,
            // 'imagetype' => $imagetype,
            // 'magasins' => $stores
        ];
    }
}

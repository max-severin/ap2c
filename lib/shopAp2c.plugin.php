<?php

/*
 * @author Max Severin <makc.severin@gmail.com>
 */

class shopAp2cPlugin extends shopPlugin
{

    static function displayAdditionalProducts($product) {

        $app_settings_model = new waAppSettingsModel();

        $settings = $app_settings_model->get(array('shop', 'ap2c'));

        if ($settings['status'] && $settings['categoryActive'] && $settings['categoryAssigned'] && $product['category_id']) {

        	$categories = array();
        	$categories[$product['category_id']] = $product['category_id'];

            $category_model = new shopCategoryModel();
            $category = $category_model->getById($product['category_id']);
            $path = $category_model->getPath($category['id']);

            if ($path) {
	            foreach ($path as $cat) {
	            	$categories[$cat['id']] = $cat['id'];
	            }
	        }	        

            if ( in_array($settings['categoryActive'], $categories) ) {

	            $active_category = $category_model->getById($settings['categoryActive']);
	            $assigned_category = $category_model->getById($settings['categoryAssigned']);

        		$sub_categories = $category_model->getSubcategories($settings['categoryAssigned']);

        		if ($sub_categories) {

        			$sub_category_products = array();

        			foreach ($sub_categories as $id => $sub_category) {
    					
    					$collection = new shopProductsCollection('category/'.$sub_category['id']);

            			$products = $collection->getProducts('*', 0, false);

            			$sub_category_products[$sub_category['id']] = $products;

        			}

	            	$view = wa()->getView(); 
		            $view->assign('ap2c_sub_categories', $sub_categories);
		            $view->assign('ap2c_sub_category_products', $sub_category_products);

		            $html = $view->fetch(realpath(dirname(__FILE__)."/../").'/templates/Frontend.html');

		            return $html;
        		}

            } else {

            	return;

            }                       

        } else {

            return;

        }        

    }

}
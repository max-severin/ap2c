<?php

/*
 * Class shopAp2cPluginBackendGetcategoriesController
 * @author Max Severin <makc.severin@gmail.com>
 */

class shopAp2cPluginBackendGetcategoriesController extends waJsonController {

    public function execute() {   

    	$result = array();
        $result['categories'] = array();
        $categories = array();

        $query = mysql_real_escape_string(waRequest::post('query', '', 'string'));      
        
        $category_model = new shopCategoryModel();
        $categories = $category_model->query("SELECT id, name, description FROM shop_category WHERE name LIKE '%".$query."%' ORDER BY name")->fetchAll();
       	
        foreach ($categories as $category) {
        	$category['description'] = substr(strip_tags( $category['description'] ), 0, 64);
        	$result['categories'][] = $category;
        }

        $this->response = $result;

    }  
      
}
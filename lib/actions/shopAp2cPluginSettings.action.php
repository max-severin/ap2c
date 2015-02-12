<?php

/*
 * Class shopAp2cPluginSettingsAction
 * @author Max Severin <makc.severin@gmail.com>
 */

class shopAp2cPluginSettingsAction extends waViewAction {

    public function execute() {

        $app_settings_model = new waAppSettingsModel();        
		$category_model = new shopCategoryModel();
        $settings = $app_settings_model->get(array('shop', 'ap2c'));

        if ($settings['categoryActive']){
        	$active_category_name = $category_model->query("SELECT name FROM shop_category WHERE id = ".$settings['categoryActive']." LIMIT 1")->fetch();
        	$this->view->assign('categoryActiveName', $active_category_name['name']);
        }
        if ($settings['categoryAssigned']){
        	$assigned_category_name = $category_model->query("SELECT name FROM shop_category WHERE id = ".$settings['categoryAssigned']." LIMIT 1")->fetch();
        	$this->view->assign('categoryAssignedName', $assigned_category_name['name']);
        }

        $this->view->assign('settings', $settings);
        
    }

}
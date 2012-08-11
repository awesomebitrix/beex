<?php

class pushin_dm extends CModule
{
    public $MODULE_ID = 'pushin.dm';
    public $MODULE_NAME = 'Привязка свойств инфоблока к разделам';
    public $MODULE_DESCRIPTION = 'Дает возможность задать для товаров разных категорий разные наборы свойств';

    public $MODULE_VERSION = '1.0';
    public $MODULE_VERSION_DATE = '2012-05-17';
    
	public function __construct() {
    
		$arModuleVersion = array();

		include(dirname(__FILE__).'/version.php');

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = 'Djem';
		$this->MODULE_DESCRIPTION = '';
		$this->PARTNER_NAME = 'pushin.pro';
		$this->PARTNER_URI = 'http://pushin.pro';
        
	}
    
    function DoInstall() {
                    
        RegisterModule($this->MODULE_ID);
                
    }
    
    function DoUninstall() {
    
        UnRegisterModule($this->MODULE_ID);

    }    
    
}

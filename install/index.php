<?php

class pushin_beex extends CModule
{
    public $MODULE_ID = 'pushin.beex';
    public $MODULE_NAME = '';
    public $MODULE_DESCRIPTION = '';

    public $MODULE_VERSION = null;
    public $MODULE_VERSION_DATE = null;

    public function __construct() {

        $arModuleVersion = array();

        include(dirname(__FILE__).'/version.php');

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

        $this->MODULE_NAME = 'Beex';
        $this->MODULE_DESCRIPTION = '';
        $this->PARTNER_NAME = 'PUSHIN Konstantin';
        $this->PARTNER_URI = 'http://pushin.pro';

    }

    function DoInstall() {

        RegisterModule($this->MODULE_ID);

    }

    function DoUninstall() {

        UnRegisterModule($this->MODULE_ID);

    }

}

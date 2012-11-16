<?php
class beCore {

    protected $serviceContainer = null;

    protected static $instance;
    public static function &getInstance($options=array()) {
        if (self::$instance === null) self::$instance = new self($options);
        return self::$instance;
    }

    public function __construct() {

        $this->initServiceContainer();

    }

    public static function getService($name) {

        return self::getInstance()->getServiceContainer()->getService($name);

    }

    public function getServiceContainer() {

        return $this->serviceContainer;

    }

    protected function initServiceContainer() {

        $this->serviceContainer = new beServiceContainer();

        $config = new beConfig();
        $config->set('paths/core', dirname(__FILE__));

        $this->serviceContainer
                ->addService('config', $config)
                ->addService('filesystem', new beFilesystem())
                ->addService('autoloader', new beAutoloader())
        ;


    }


}

?>

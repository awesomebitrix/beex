<?php
class dmServiceContainer {

    protected $services = array();

    public function initServices() {

        $config = dmCore::getService('config');

        foreach($config->get('services') as $name => $options) {

            $this->addService($name, $options);
            
        }

    }

    public function getService($name) {

        if (!$this->hasService($name)) throw new Exception("Service $name is not found");

        $service = $this->services[$name];

        if (!$service['object']) {

            $class = $service['options']['class'];

            $this->services[$name]['object'] =  new $class();

        }

        return $this->services[$name]['object'];

    }

    public function addService($name, $service) {

        $options = $object = null;

        if (is_array($service)) $options = $service;
        else $object = $service;

        $this->services[$name] = array('options' => $options, 'object' => $object);

        return $this;

    }

    public function hasService($name) {

        return isset($this->services[$name]);

    }

}

?>

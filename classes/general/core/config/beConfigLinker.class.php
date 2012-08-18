<?php
class beConfigLinker extends beConfigurable {

    protected $layers = array();

    protected $configs = array();

    public function getDefaultOptions() {

        return array('paths' => array());

    }

    public function buildLayers() {

        foreach(beArray::fetch($this->getOption('paths')) as $path) {
            $newLayer = new beConfigLinkerLayer(array(
                'path' => $path,
            ));
            $newLayer->load();
            $this->addLayer($newLayer);
        }

        return $this;

    }

    public function addLayer(beConfigLinkerLayer $layer) {

        $this->layers[] = $layer;

    }

    public function buildConfigs() {
        foreach($this->layers as $layer) {
            $layerConfigs = $layer->getData();
            $this->addConfigsRecursivly($layerConfigs);
        }
        return $this;
    }

    public function addConfigsRecursivly($configs, $path = '') {
        foreach($configs as $key => $value) {
            $nextPath = $path? $path.'/'.$key : $key;
            if (is_array($value)) {
                $this->addConfigsRecursivly($value, $nextPath);
            }
            else {
                $this->addConfig($nextPath, $value);
            }
        }
    }

    public function addConfig($path, $value) {
        $pathParts = explode('/', $path);
        $config = &$this->configs;
        foreach($pathParts as $pathPart) {
            if (!isset($config[$pathPart])) $config[$pathPart] = array();
            $config = &$config[$pathPart];
        }
        $config = $value;
    }



    public function getConfigs() {

        return $this->configs;

    }

    public function setConfigs($configs) {

        $this->configs = $configs;

    }

}

?>

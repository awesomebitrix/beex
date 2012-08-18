<?php
class beConfig extends beConfigurable {

    protected $config = null;

    protected $paths = array();

    public function __construct($options = array()) {

        $this->configure($options);

    }

    public function getDefaultOptions() {
        return array(
            'cacheRelativePath' => '/config.cache',
        );
    }

    public function load() {

        $config = $this->loadConfigFromCache();

        if (!$config) {

            $config = $this->loadConfigFromLayers();

            if (is_array($config)) $this->saveConfigToCache($config);

        }

        $this->config = $config;

    }

    public function resetConfig() {

        $this->config = null;

    }

    protected function saveConfigToCache($config) {

        $path = $this->getCacheFilePath();

        if ($path) {

            file_put_contents($path, serialize($config));

        }

    }


    protected function loadConfigFromCache() {

        $config = null;

        $path = $this->getCacheFilePath();

        if ($path && file_exists($path)) {

            $config = unserialize(file_get_contents($path));

        }

        return $config;

    }


    protected function getCacheFilePath() {

        $cachePath = $this->get('paths/cache');
        $cacheRelativePath = $this->getOption('cacheRelativePath');

        $path = ($cachePath && $cacheRelativePath)? $cachePath.$cacheRelativePath : null;

        return $path;

    }

    public function loadConfigFromLayers() {

        $linker = new beConfigLinker();

        $linker->setConfigs($this->config);

        $linker
            ->setOption('paths', $this->paths)
            ->buildLayers()
            ->buildConfigs()
        ;

        return $linker->getConfigs();

    }

    public function set($path, $value) {

        $pathParts = explode('/', $path);
        $config = &$this->config;
        foreach($pathParts as $pathPart) {
            if (!isset($config[$pathPart])) $config[$pathPart] = array();
            $config = &$config[$pathPart];
        }
        $config = $value;

    }

    public function get($path) {

        if (!$this->config) $this->load();

        $pathParts = explode('/', trim($path, '/'));
        $value = $this->config;
        foreach($pathParts as $pathPart) {
            if (isset($value[$pathPart])) $value = $value[$pathPart];
            else {
                $value = null;
                break;
            }
        }
        return $value;
    }

    public function addPath($path) {
        $this->paths[] = $path;
        return $this;
    }

}

?>

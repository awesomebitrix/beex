<?php
class beCache extends beConfigurable {

    public function __construct($options = array()) {

        $this->configure($options);

    }

    public function getDefaultOptions() {

        return array(
            'rootPath' => 'djem_cache',
            'lifetime' => 864000,
        );

    }

    public function get($key) {

        $cache = new CPHPCache();
        if (!$cache->InitCache(null, $key, $this->getPath())) return null;

        return $cache->GetVars();

    }

    public function has($key) {

        $cache = new CPHPCache();

        return $cache->InitCache(null, $key, $this->getPath());

    }

    public function set($key, $value, $lifetime = null) {

        if (is_null($lifetime)) $lifetime = $this->getOption('lifetime');

        $cache = new CPHPCache();
        $cache->StartDataCache($lifetime, $key, $this->getPath());
        $cache->EndDataCache($value);

    }

    public function getPath() {

        $rootPath = $this->getOption('rootPath');
        $path = $this->getOption('path');

        return $path? $rootPath.$path : null;

    }

}
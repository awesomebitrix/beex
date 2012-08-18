<?php
class beAutoloader {

    protected $libs = array();

    protected $paths = array();

    public function init() {

        $config = beCore::getService('config');

        $this->addLib($this->getModuleLibPath());

        $events = GetModuleEvents($config->get('beModuleId'), 'BeexAutoloaderInit');

        while($event = $events->Fetch()) ExecuteModuleEvent($event, $this);

        return $this;

    }

    protected function getModuleLibPath() {

        $config = beCore::getService('config');

        $path = $config->get('paths/module');
        if (!$path) throw new Exception('Module path is not specified');

        return $path.'/classes/general/lib';

    }

    public function addLib($path) {

        if (!is_dir($path)) return;

        $this->libs[] = new beAutoloaderLib($path);

    }

    public function register() {

        CModule::AddAutoloadClasses('', $this->getPaths());

    }

    public function getPaths() {

        if (!$this->paths) $this->loadPaths();

        return $this->paths;

    }

    public function loadPaths() {

        $cache = new beAutoloaderCache();

        $this->paths = $cache->get('paths');
        $this->paths = array();

        if (!$this->paths) {

            $this->paths = $this->findPaths();

            $cache->set('paths', $this->paths);

        }

    }

    protected function findPaths() {

        $classes = array();

        foreach($this->libs as $lib) $classes = array_merge($classes, $lib->findClasses());

        return $classes;

    }

}
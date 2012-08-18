<?php
class dmAutoloader {

    protected $libs = array();

    protected $paths = array();

    public function init() {

        $config = dmCore::getService('config');

        $this->addLib($this->getModuleLibPath());
        $events = GetModuleEvents($config->get('dmModuleId'), 'OnBeforeDmAutoloaderRegister');

        while($event = $events->Fetch()) ExecuteModuleEvent($event, $this);

        return $this;

    }

    protected function getModuleLibPath() {

        $config = dmCore::getService('config');

        $path = $config->get('paths/module');
        if (!$path) throw new Exception('Module path is not specified');

        return $path.'/classes/general/lib';

    }

    public function addLib($path) {

        if (!is_dir($path)) return;

        $this->libs[] = new dmAutoloaderLib($path);

    }

    public function register() {

        CModule::AddAutoloadClasses('', $this->getPaths());

    }

    public function getPaths() {

        if (!$this->paths) $this->loadPaths();

        return $this->paths;

    }

    public function loadPaths() {

        $cache = new dmAutoloaderCache();

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
<?php
class dmAutoloader {

    protected $libs = array()

    protected $paths = array();
    
        
    public function addLib($path) {
    
        $this->libPaths[] = new dmAutoloaderLib($path);
    
    }
    
    public function register() {
    
        CModule::AddAutoloadClasses('pushin.dm', $this->getPaths());
    
    }    
    
    public function getPaths() {
    
        if (!$this->paths) $this->loadPaths();
    
        return $this->classesPaths;
    
    }
    
    public function loadPaths() {
    
        $cache = new dmAutoloaderCache();
        
        $this->paths = $cache->get('paths');
        
        if (!$this->paths) {
        
            $this->paths = $this->findPaths();
        
            $cache->set('paths', $this->paths);
            
        }
    
    }
    
    protected function findPaths() {
    
        $classes = array()
    
        foreach($this->libs as $lib) $classes = array_merge($classes, $lib->findClasses());
        
        return $classes;
    
    }

}
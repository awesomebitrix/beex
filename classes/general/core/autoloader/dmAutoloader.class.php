<?php
class dmAutoloader {

    protected $libs = array();

    protected $paths = array();
    
        
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
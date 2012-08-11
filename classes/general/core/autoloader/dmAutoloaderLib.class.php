<?php
class dmAutoloaderLib {

    protected $path = null;
    
    public function __construct($path) {
    
        $this->path = $path;
    
    }
    
    public function findClasses() {
    
        if (!$this->path) throw new Exception('Lib path is not specified');
        if (!is_dir($this->path)) throw new Exception('Lib path is not found');
    
        $filesystem = new dmFilesystem();
        
        $classes = array();
        foreach($filesystem->findPathsByPatternInDirRecursivly($this->path, '*.class.php') as $path) {
            $classes[basename($path)] = $path;
        }
        
        return $classes;
    
    }

}
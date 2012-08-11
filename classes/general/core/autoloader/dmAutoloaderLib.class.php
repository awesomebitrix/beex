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
        
        $modulePath = realpath(dmCore::getService('config')->get('paths/module'));
        
        foreach($filesystem->findPathsByPatternInDirRecursivly($this->path, '*.class.php') as $path) {            
                
            $path = realpath($path);
            $relativePath = preg_replace('%^'.$modulePath.'%six', '', $path);
            $className = dmArray::first(explode('.', basename($relativePath)));

            $classes[$className] = $relativePath;
            
        }
        
        return $classes;
    
    }

}
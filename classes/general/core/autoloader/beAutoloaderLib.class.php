<?php
class beAutoloaderLib {

    protected $path = null;

    public function __construct($path) {

        $this->path = $path;

    }

    public function findClasses() {

        if (!$this->path) throw new Exception('Lib path is not specified');
        if (!is_dir($this->path)) throw new Exception('Lib path is not found');

        $filesystem = new beFilesystem();

        $classes = array();

        $rootPath = realpath(beCore::getService('config')->get('paths/root'));

        foreach($filesystem->findPathsByPatternInDirRecursivly($this->path, '*.class.php') as $path) {

            $path = realpath($path);
            $relativePath = preg_replace('%^'.$rootPath.'%six', '', $path);

            $className = beCoreArray::first(explode('.', basename($relativePath)));

            $classes[$className] = $relativePath;

        }

        return $classes;

    }

}
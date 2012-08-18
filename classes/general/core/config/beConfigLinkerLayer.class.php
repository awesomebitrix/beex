<?php
class beConfigLinkerLayer extends beConfigurable {

    protected $data = array();

    public function __construct($options = array()) {

        $this->configure($options);

    }

    public function getDefaultOptions() {

        return array('path' => array());

    }

    public function load() {

        $yamlParserPath = beCore::getService('config')->get('paths/core').'/yaml/beYamlParser.class.php';

        include_once $yamlParserPath;

        $parser = new beYamlParser();

        foreach($this->getConfigFilesPaths() as $path) {
            $yaml = file_get_contents($path);

            $bindPath = null;
            if (preg_match('/^#path:(.*)/', $yaml, $matches)) {
                $bindPath = trim(beCoreArray::get($matches, 1));
            }
            $bindPath = $bindPath? $bindPath : '';
            $this->addConfigsRecursivly($parser->execute($yaml), $bindPath);
//            $this->data = array_merge(
//                    $this->data,
//                    $parser->execute($path)
//            );

        }
        return $this;

    }

    public function getConfigFilesPaths() {
        $path = $this->getOption('path');
        $filesystem = beCore::getService('filesystem');
        return $filesystem->findPathsByPatternInDirRecursivly($path, '*.yml');
    }

    public function getData() {
        return $this->data;
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
        $config = &$this->data;
        foreach($pathParts as $pathPart) {
            if (!isset($config[$pathPart])) $config[$pathPart] = array();
            $config = &$config[$pathPart];
        }
        $config = $value;
    }


}

?>

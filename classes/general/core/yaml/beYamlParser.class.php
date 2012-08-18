<?php
require_once dirname(__FILE__).'/vendor/spyc/spyc.php';
class beYamlParser {
    public function execute($yaml) {
        return Spyc::YAMLLoadString($yaml);
    }
}

?>

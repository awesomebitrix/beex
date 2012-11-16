<?php
class beAutoloaderCache extends beCache {

    public function getDefaultOptions() {

        return array_merge(parent::getDefaultOptions(), array(
            'path' => '/autoloader',
        ));

    }

}
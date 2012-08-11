<?php
class dmAutoloaderCache extends dmCache {
    
    public function getDefaultOptions() {
    
        return array_merge(parent::getDefaultOptions(), array(
            'path' => '/autoloader',
        ));
    
    }

}
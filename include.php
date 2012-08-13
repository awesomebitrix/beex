<?php
CModule::AddAutoloadClasses('pushin.dm', array(

    'dmConfigurable' => 'classes/general/core/base/dmConfigurable.class.php',
    'dmArray' => 'classes/general/core/base/dmArray.class.php',


    'dmAutoloader' => 'classes/general/core/autoloader/dmAutoloader.class.php',
    'dmAutoloaderLib' => 'classes/general/core/autoloader/dmAutoloaderLib.class.php',
    'dmAutoloaderCache' => 'classes/general/core/autoloader/dmAutoloaderCache.class.php',
    
    'dmCache' => 'classes/general/core/cache/dmCache.class.php',
    'dmFilesystem' => 'classes/general/core/filesystem/dmFilesystem.class.php',

    'dmConfig' => 'classes/general/core/config/dmConfig.class.php',
    'dmConfigLinker' => 'classes/general/core/config/dmConfigLinker.class.php',
    'dmConfigLinkerLayer' => 'classes/general/core/config/dmConfigLinkerLayer.class.php',

    'dmServiceContainer' => 'classes/general/core/service/dmServiceContainer.class.php',
    
    'dmYamlParser' => 'classes/general/core/yaml/dmYamlParser.class.php',
    
    'dmCore' => 'classes/general/core/dmCore.class.php',
    
));

$config = dmCore::getService('config');
$config->setOption('cacheRelativePath', "/config.cache");
$config->set('paths/cache', $_SERVER['DOCUMENT_ROOT'].'/bitrix/cache/s1/dm_cache');
$config->set('paths/module', dirname(__FILE__));
$config->set('paths/root', $_SERVER['DOCUMENT_ROOT']);
$config->set('dmModuleId', 'pushin.dm');

$config->addPath(dirname(__FILE__).'/config');
$config->load();

dmCore::getService('autoloader')->init()->register();


<?php
CModule::AddAutoloadClasses('pushin.beex', array(

    'beConfigurable' => 'classes/general/core/base/beConfigurable.class.php',
    'beCoreArray' => 'classes/general/core/base/beCoreArray.class.php',


    'beAutoloader' => 'classes/general/core/autoloader/beAutoloader.class.php',
    'beAutoloaderLib' => 'classes/general/core/autoloader/beAutoloaderLib.class.php',
    'beAutoloaderCache' => 'classes/general/core/autoloader/beAutoloaderCache.class.php',

    'beCache' => 'classes/general/core/cache/beCache.class.php',
    'beFilesystem' => 'classes/general/core/filesystem/beFilesystem.class.php',

    'beConfig' => 'classes/general/core/config/beConfig.class.php',
    'beConfigLinker' => 'classes/general/core/config/beConfigLinker.class.php',
    'beConfigLinkerLayer' => 'classes/general/core/config/beConfigLinkerLayer.class.php',

    'beServiceContainer' => 'classes/general/core/service/beServiceContainer.class.php',

    'beYamlParser' => 'classes/general/core/yaml/beYamlParser.class.php',

    'beCore' => 'classes/general/core/beCore.class.php',

));

$config = beCore::getService('config');
$config->setOption('cacheRelativePath', "/config.cache");
$config->set('paths/cache', $_SERVER['DOCUMENT_ROOT'].'/bitrix/cache/s1/be_cache');
$config->set('paths/module', dirname(__FILE__));
$config->set('paths/root', $_SERVER['DOCUMENT_ROOT']);
$config->set('beModuleId', 'pushin.beex');

$config->addPath(dirname(__FILE__).'/config');
$config->load();

beCore::getService('autoloader')->init()->register();


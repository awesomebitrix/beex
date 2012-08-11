<?php
CModule::AddAutoloadClasses('pushin.dm', array(

    'dmConfigurable' => dirname(__FILE__).'/classes/general/core/base/dmConfigurable.class.php',
    'dmArray' => dirname(__FILE__).'/classes/general/core/base/dmArray.class.php',


    'dmAutoloader' => dirname(__FILE__).'/classes/general/core/autoloader/dmAutoloader.class.php',
    'dmAutoloaderLib' => dirname(__FILE__).'/classes/general/autoloader/core/dmAutoloaderLib.class.php',
    'dmAutoloaderCache' => dirname(__FILE__).'/classes/general/autoloader/core/dmAutoloaderCache.class.php',
    
    'dmCache' => dirname(__FILE__).'/classes/general/core/cache/dmCache.class.php',
    'dmFilesystem' => dirname(__FILE__).'/classes/general/core/filesystem/dmFilesystem.class.php',
    
));

$autoloader = new dmAutoloader();
$autoloader->addLib(dirname(__FILE__).'/classes/general/lib');
$autoloader->register();
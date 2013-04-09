<?php
require 'modules/config.php';

/*
 * Load the modules so that they can be used
 */
Flight::map('loadModules', function() {
    foreach(Flight::get('modules') as $mod) {
        Flight::route($mod['path'], $mod['file']);
    }
});

/*
 * Fetch a list of the installed modules so we can list them on the front page
 * @return array
 */
Flight::map('getModuleList', function() {
    $modules = array();
    foreach(Flight::get('modules') as $k => $a) {
        array_push($modules, array( $k => $a['path']));
    }
    return $modules;
});
?>

<?php
require 'flight/Flight.php';

require 'routes/api.php';
require 'routes/main.php';
require 'routes/modules.php';

Flight::before('start', function(&$params, &$output) {
	Flight::render('header');
        Flight::render('navbar');
        Flight::checkServiceID();
        Flight::loadModules();
});

Flight::after('start', function(&$params, &$output) {
	Flight::render('footer');
});

Flight::map('notFound', function() {
    Flight::render('404');
    return false;
});

Flight::start();

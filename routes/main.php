<?php
Flight::route('/', 'home');
Flight::route('/home', 'home');
Flight::route('/index', 'home'); 

function home() {
    Flight::render('home', array( 'modArray' => Flight::getModuleList() ));
}
?>

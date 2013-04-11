<?php
/*
 * Service Id (You can get a service id here: https://census.soe.com/)
 * @var string
 */
Flight::set('sid', '');

/*
 * Sony Game (By default this is ps2)
 * @var string
 */
Flight::set('sg', 'ps2');

/*
 * SOE API url
 * @var string
 */
Flight::set('surl', 'http://census.soe.com/');

/*
 * Set array of valid types
 * @var array
 */
Flight::set('stypes', array(
    'character',
    'characters_friend',
    'characters_online_status',
    'event',
    'characters_event',
    'characters_event_grouped',
    'world',
    'characters_world',
    'map',
    'indarmap',
    'amerishmap',
    'esamirmap',
    'leaderboard',
    'outfit',
    'outfit_member'
));

Flight::set('sid', 's:elystus');

/*
 * Starts the api data fetching process
 * @return array
 */
Flight::map('apiStart', function($verb, $type, $action) {
    Flight::apiVerifyVerb($verb);
    Flight::apiVerifyType($type);
    $url = Flight::apiConstructUrl($verb, $type, $action);
    $apiData = Flight::apiFetchData($url);
    return $apiData;
});

/*
 * Check to see if supplied verb is valid
 * @return boolean
 */
Flight::map('apiVerifyVerb', function($verb) {
    if(strtolower($verb) == 'get' || strtolower($verb) == 'count') {
        return true;
    } else {
        $msg = 'The verb that was supplied is not valid. Supplied verb: {' . $verb . '}';
        Flight::view()->set('msg', $msg);
        Flight::render('error');
        Flight::stop();
    }
});

/*
 * Check to see if supplied type is valid
 * @return boolean
 */
Flight::map('apiVerifyType', function($type) {
    if(in_array(strtolower($type), Flight::get('stypes'))) {
        return true;
    } else {
        $msg = 'The type that was supplied is not valid. Supplied verb: {' . $type . '}';
        Flight::view()->set('msg', $msg);
        Flight::render('error');
        Flight::stop();
    }
});

/*
 * Fetch data using SOE API
 * @return array
 */
Flight::map('apiFetchData', function($url) {
    
    $result = file_get_contents($url,0,null,null);
    
    $obj = json_decode($result, true);              // Convert the data we fetched to an array
    
    return $obj;
});

/*
 * Converts object to array
 * @return array
 */
Flight::map('apiToArray', function($obj) {
    if (is_object($obj)) {
        $obj = get_object_vars($obj);
    }
 
    if (is_array($obj)) {
        return array_map(__FUNCTION__, $obj);
    }
    else {
        return $obj;
    }
});

/*
 * Construct url for interaction with SOE API
 * @return string
 */
Flight::map('apiConstructUrl', function($verb, $type, $action) {
    $url = Flight::get('surl');         // Url for sony's api

    $url .= Flight::get('sid') . '/';   // Adds our station id to the link
    $url .= $verb . '/';                // Adds our verb to the link (get or count)
    $url .= Flight::get('sg') . '/';    // Adds the game we are fetching data for to the link
    $url .= $type . '/?';
    
    $action = new CachingIterator(new ArrayIterator($action)); // Allows us to look for the last iteration of the foreach statement
    
    foreach($action as $k => $a) {
        if ($action->hasNext()) {
            $url .= $k . '=' . $a . '&';
        } else {
            $url .= $k . '=' . $a;
        }
    }
    return $url;
});

Flight::map('checkServiceID', function() {
    $sid = Flight::get('sid');
    if(empty($sid)) {
        $msg = 'There was no service ID defined! A service ID needs to be defined in order for server requests to be made. Please add your service ID to api.php.';
        Flight::view()->set('msg', $msg);
        Flight::render('error');
        Flight::stop();
    } else {
        return true;
    }
});

?>

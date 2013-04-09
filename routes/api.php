<?php
/*
 * Service Id (You can get a service id here: https://census.soe.com/)
 * @var string
 */
Flight::set('sid', 's:elystus');

/*
 * Sony Game (By default this is ps2)
 * @var string
 */
Flight::set('sg', 'ps2');

/*
 * SOE API url
 * @string
 */
Flight::set('surl', 'http://census.soe.com/');

/*
 * Fetch data using SOE API
 * @return array
 */
Flight::map('apiFetchData', function($verb, $action) {
    
    $url = Flight::apiConstructUrl($verb, $action);
    
    $ch = curl_init($url);
    
    $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
    );
    curl_setopt_array( $ch, $options );
    $result =  curl_exec($ch); 
    
    $obj = Flight::apiToArray(json_decode($result)); // Convert the data we fetched to an array
    
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
Flight::map('apiConstructUrl', function($verb, $action) {
    if( strtolower($verb) == 'get' || strtolower($verb) == 'action') {
        $url .= Flight::get('surl');
        $url .= Flight::get('sid');
        $url .= '/' . $verb . '/?';
        foreach($action as $k => $a) {
            $url .= $k . '=' . $a . '&';
        }
        return $url;
    } else {
        $msg = 'There was an error in the API url construction. `' . $verb. '` was not identified as a valid verb';
        Flight::view()->set('msg', $msg);
        Flight::render('error');
        return false;
    }
});
?>

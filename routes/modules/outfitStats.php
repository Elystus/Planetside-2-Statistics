<?php
Flight::route('/outfit(/@type(/@var))', 'outfitStats');

Flight::route('POST /outfit', 'outfitPost');
Flight::route('POST /outfit/*', 'outfitPost');

/*
 * The methods through which you can search for a Outfits information
 * @var array
 */
Flight::set('outfitTypes', array(
    'tag' => array(
        'verb' => 'get',
        'type' => 'outfit',
        'arrayKey' => 'outfit_list'
    ),
    'name' => array(
        'verb' => 'get',
        'type' => 'outfit',
        'arrayKey' => 'outfit_list'
    ),
    'member' => array(
        'verb' => 'get',
        'type' => 'character',
        'type2' => 'outfit_member',
        'arrayKey' => 'outfit_member_list'
    )
));

function outfitStats($path, $var) {
    if(!empty($path) && array_key_exists(strtolower($path), Flight::get('outfitTypes'))) {
        $outfitID = Flight::outfitFetchID($path, $var);
        $outfitData = Flight::outfitGetData($outfitID);
    } else {
        Flight::render('outfitStats');
    }
}

function outfitPost() {
        $url = '/outfit/' . $_POST['outfit-type'] . '/' . $_POST['outfit-var'];
        Flight::redirect($url);
}

Flight::map('outfitFetchID', function($path, $var) {
    
    $verb = Flight::get('outfitTypes')[$path]['verb'];
    $type = Flight::get('outfitTypes')[$path]['type'];
    $arrayKey = Flight::get('outfitTypes')[$path]['arrayKey'];
    
    if(strtolower($path) == 'tag') {
        $action = array( 'alias' => $var);
    } elseif(strtolower($path) == 'name') {
        $action = array( 'name' => $var );
    } elseif(strtolower($path) == 'member') {
        $action = array( 'name.first_lower' => strtolower($var), 'c:show' => 'name');
        $memberData = Flight::apiStart($verb, $type, $action);
        if(!empty($memberData['character_list'][0]['id'])) {
            $action = array( 'character_id' => $memberData['character_list'][0]['id'], 'c:resolve' => 'outfit(alias,name)');
            $type = Flight::get('outfitTypes')[$path]['type2'];
        } else {
                $msg = 'The clan tag, member, or name that you used was not found in the Planetside 2 database. Be sure that you typed the name correctly.';
                Flight::view()->set('msg', $msg);
                Flight::render('error');
                Flight::stop();
        }
    } else {
        Flight::render('outfitStats');
        return false;
    }
    
    $outfitData = Flight::apiStart($verb, $type, $action);
    if(!empty($outfitData[$arrayKey][0]['id'])) {
            return $outfitData[$arrayKey][0]['id'];
    } else {
            $msg = 'The clan tag, member, or name that you used was not found in the Planetside 2 database. Be sure that you typed the name correctly.';
            Flight::view()->set('msg', $msg);
            Flight::render('error');
            Flight::stop();
    }
});

Flight::map('outfitGetData', function($outfitID) {
    
    $verb = 'count';
    $type = 'outfit_member';
    $actionC = array( 'id' => $outfitID );
    $outfitData = Flight::apiStart($verb, $type, $actionC);
    echo $outfitData['outfit_member_list'][0]['count'];
});
?>

## Planetside 2 API Interface
==================================

#### What is this project?

This projects aims to create an easy to use graphical interface for Planetside 2's api. The website uses bootstrap and the [Flight PHP microframework](http://flightphp.com/). Modules require very little work to make, and are easy to add to the project. 


#### What do I need to do?

* Install the flight framework in the same directory as the index file in this project. Aka, where the link in this repsitory is! :O
* Setup the webserver to work with flight. Information on how to do this can be found [here](http://flightphp.com/install).
* Request a [service ID](http://census.soe.com/#devSignup), and define it in api.php
* Sit back and enjoy the fountain of Planetside 2 statistics!


#### How do I create a module for this website?

- The first thing that you should do is setup the module's variables in the [config.php](https://github.com/Elystus/Planetside-2-site/blob/master/routes/modules/config.php) file. The array format for a new module is below:

        'Module Name' => array(
            'author' => 'Your name here',
            'file' => 'name of your file in the modules folder',
        )
        
        
- Define the paths for the module. This is where having some knowledge of the [flight framework](http://flightphp.com/learn) would come in useful. A few examples of paths being defined are shown below:

    ###### Path with no variables defined
        Flight::route('/awesomeModule', 'awesomeMod');
        
    ###### Path with variables defined
        Flight::route('/coolBeans(/@cool(/@beans)', 'coolBeans');
        

- Create a function for the path. This should be the second argument of Flight::route function. Examples for the above two paths:

    ###### No defined variables
        function awesomeMod() {
            // Insert Fabulous code here!
        }

    ###### Defined variables
        function coolBeans( $cool, $beans ) {
            // Awesome code here!
        }
        
        
- Now comes the fun part, we get to request data from Sony's servers. To do this we need to define a few variables and call the apiStart() function. Don't worry, just follow the steps below!
    
  * Define the method that you want to retrieve that data as $verb. (get or count)
  * Define the type of data you are looking for as $type. 
    
    ###### The types
        character, 
        characters_friend,
        characters_online_status, 
        event, characters_event, 
        characters_event_grouped, 
        world, 
        characters_world,
        map, 
        indarmap, 
        amerishmap, 
        esamirmap, 
        leaderboard, 
        outfit, 
        outfit_member

    
  * Define the arguments of the url as an array called $action. The array key will be used as the variable being defined in the url, so assign appropriate array keys. All of the url arguments can be found on [Sony's API documentation](http://census.soe.com/).
    
    ###### Example:
        $action = array( 'id' => '37509488620601345', 'c:resolve' => 'member' );


  * Retrieve your data using apiStart(). 
    
    ##### Example:
        $verb = 'get';
        $type = 'outfit';
        $action = array( 'id' => '37509488620601345', 'c:resolve' => 'member' );
        $outfitData = Flight::apiStart( $verb, $type, $action );


- After you have retrieved your data, you can set it as a views variable using Flight::view()->set(). THen you can render your array using Flight::render().

    ###### Example:
        Flight::view()->set('data', $dataYouGot);
        Flight::render('nameOfFileInViews');
        

- You're almost done! Now just create a file in the views folder with the same name as the file you are defining in the Flight::redner() function. To use the variables you defined, just take the string that you defined in argument 1 of Flight::view()->set() is now a variable. For the example above, you would use $data.

- Use the module that you made! If you like it, commit it to this project and it may be added! :D

     

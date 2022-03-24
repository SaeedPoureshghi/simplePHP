<?php
    
    include '.env';
    include 'init.php';
    
    Route::all();
    Route::add('/','GET');
 
    
    //Route::auth();
    //*TODO: Routes that need Authentication

    //Route::admin();
    //*TODO: Routes that need Admin Access
    
    
    Route::run();
    
?>
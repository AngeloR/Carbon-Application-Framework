<?php session_start();
/**
 * This is the base of the Carbon Application Framework. It is loaded with
 * every request. It creates the {@Sess Router} and currently provides rudimentary
 * error reporting that will most likely be replaced.
 *
 * @package caf
 * @author xangelo
 */
//-------------- Includes -------------- //
require_once('CarbonLib.php');
using('Core.Library.Router');


//-------------- Start Router Procesing -------------- //
try {
    using('Core.Base.CarbonApp');
    $CarbonApp = CarbonApp::GetInstance();
    $Router = new Router();
    
    //------- Everything below this line is temporary error checking! ------- //
    $x = error('');
    if(count($x) > 0) {
        
        foreach($x as $i=>$m) {
            echo '<ul>';
            foreach($m as $u=>$a) {
                echo '<li>'.$a.'</li>';
            }
            echo '</ul>';
        }
        
    }
    //-------------- Everything above this line is temporary! -------------- //
}
catch(Exception $e) {
    // Suppress all exceptions except those registered with us.
    // Perhaps an error logging module would tie in here? Perhaps
    // make it part of the core
}
?>

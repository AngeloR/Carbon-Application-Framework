<?php
/**
 * @package Router
 * @author xangelo
 */
/**
 * The Router class handles all the url manipulation tasks. Routes are pre-defined
 * as ?q=Controller/Action/{Any/of/these/are/arguments/for/Action}
 *
 * Controller and Action are mandatory, although a default action may be implemented
 * during a later version. Anything between {} will be passed to Action as an
 * indexed array. They are passed in the order they appear in the url! (0indexed)
 */

class Router {

    private $controller;
    private $action;
    private $args;
    private $request;

    /**
     * The Router will begin to immediately route all URL's to their respective
     * Controllers. If you turn delay_processing on, you can stop that.. although
     * I use it more for testing purposes, someone might have use for it
     * @param bool $delay_processing
     */
    public function __construct($delay_processing = false) {
        
        $tmp = s($_GET['q']);
        $this->request = $tmp;
        $e = explode('/',$this->request);

        // Set defaults
        $this->controller = ($e[0]=='')?'Default':$e[0];
        array_shift($e);
        $this->action = ($e[0]=='')?'home':$e[0];
        array_shift($e);
        $this->args = $e;
        $e = implode('/',$e);
        $this->request = $this->controller.'/'.$this->action;
        $this->request .= ($e == '')?'':'/'.$e;
        
        // Redirect to our parsed url if the requested url is not
        // the same as our parsed url. This fixes missing arguements
        // from the url.
        if($tmp != $this->request) {
            header('location: index.php?q='.$this->request);
        }
        
        if(!$delay_processing) {
            
            $this->Process();
        }
    }

    /**
     * Loads the necessary Classes to begin processing the page.
     * Includes the base controllers and calls the appropriate actions
     */
    public function Process() {
        
        // Need to write a check to ensure something.something.controller
        // will evaluate to Controllers/something/something/controllerController.php 
        if(file_exists('Controllers/'.$this->controller.'Controller.php')) {
            using('Core.Base.Controller');
            using('Controllers.'.$this->controller.'Controller');
            if(class_exists($this->controller.'Controller')) {
                $cname = $this->controller.'Controller';

                $c = new $cname;
                if(method_exists($c,$this->action)) {
                    $a = $this->action;
                    $c->$a($this->args);
                }
                else {
                    error($this->action.' is not a valid action');
                }
            }
            else {
                error($this->controller.' controller improperly named');
                
            }
        }
        else {
            error($this->controller.' controller does not exist');
        }
    }
}
?>

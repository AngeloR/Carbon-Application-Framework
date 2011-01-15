<?php
/**
 * Base Controller object. Extended by user-created controller objects before use. 
 *
 * @author xangelo
 * @package Core
 * @subpackage Base
 */

/**
 * The Controller object provides standard access to various Loading methods [
 * {@see Controller::LoadModel()}, {@see Controller::LoadModule()},...] as well
 * as initiates the session object.
 *
 * Since the Controller is essentially what runs your application, it MUST be
 * extended by all your Controllers. Extending Controllers should not contain their
 * own __construct() method, since it is irrelevant. 
 */
abstract class Controller {

    public $Session;
    public $CarbonApp;

    /**
     * Cache a copy of the ArrayConfig so that we can
     * use it as necessary.
     * 
     * Creates the base controller and initializes the Logging Manager and 
     * Session Manager.
     * 
     * @global array $config
     * @see Controller::InitLogging()
     * @see Controller::InitSession()
     */
    public function __construct() {
        $this->CarbonApp = CarbonApp::GetInstance();
        $this->InitLogging();   // Set up logging if it is necessary
        $this->InitSession();   // Set up sessions
    }

    /**
     * Initalize any logging manager that is set in CarbonConfig.php
     *
     * @see CarbonConfig
     */
    private function InitLogging() {        
        $log_manager = $this->CarbonApp->Config('log_manager');
        if($log_manager != ''){
            $this->log = CarbonApp::LoadModule('KLogger',array());
        }
        else {
            $this->log = new stdClass;  //bypass for not throwing errors if log exists
        }
    }

    /**
     * Initalize a new SessionManager object
     * @see SessionManager
     */
    private function InitSession() {
        using('Core.Library.Session');
        if($_SESSION[$this->CarbonApp->Config('session.name')] == '') {
            $this->Session = new SessionManager($this->CarbonApp->Config('session'));
        }
        else {
            $this->Session = new SessionManager($this->CarbonApp->Config('session.name'));
        }
    }

    /**
     * A shortcut to load an initiate any model. Models are ALWAYS passed
     * the db configuration array but are free to ignore it if another
     * system is in place.
     * 
     * @param string $model
     */
    protected function LoadModel($model) {
        using('Core.Base.Model');
        using('Models.'.$model.'Model');
        $c = $model.'Model';
        
        $this->$c = new $c($this->CarbonApp->Config('db'));
    }


    /**
     * A shortcut to load any view
     * @param string $view
     */
    protected function LoadView($view) {
        using('Views.'.$view.'View');
        $v = $view.'View';
        $this->$v = new $v();
    }
    
}
?>

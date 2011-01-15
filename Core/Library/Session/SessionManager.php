<?php
/**
 * @package Session
 * @author xangelo
 */

/**
 * Session Management Object
 *
 * The session manager is invoked during instantiation of the base Controller class.
 * It works almost like a collection but there is no option for traversal through
 * session variables, since it is unnecessary.
 *
 * Session variables are stored as properties to a session class which is serialized
 * and added to the session whenever a new element is added or removed from the session.
 * Therefore there is never a need to explicity call the Set() method from within
 * your class.
 *
 * The SessionManager allows for what is known as Flash sessions. These are pieces of
 * information that are only available for a request. IE. It can be set on Default/home
 * and will be available to you from Default2/home if you go there next, but it immediately
 * cleared after that.
 *
 * Access to the Session Manager is allowed through $this->Session from within your
 * controller. To adhere to strict MVC principles, SessionManager() is not implicitly
 * declared from within Views or Models. You can however, if necessary, utilize the
 * SessionManager after invoking a new session.
 *
 * Usage:
 *
 * From within your controller:
 * $this->Session->Add('key','value');
 * $this->Session->Get('key');
 *
 *
 * Instantiating the SessionManager manually
 * using('Core.Library.Session');
 * $config = include('CarbonConfig.php');
 * $session = new SessionManager($config['session']);
 * $session->Add('key','value');
 * $session->Get('key');
 *
 * Note: Session values are automatically sanitized.
 */
class SessionManager {
    
    private $name;
    private $session;
    private $flash;

    /**
     * Initializes the session manager
     *
     * Creates a new session if it does not exist. If it does it simply loads the
     * old session data into itself so that you can access it via $this->Get(). If
     * there were any Flash session variables set, it will store them separately
     *
     * @param mixed $session_config
     * @return object
     */
    public function __construct($session_config) {
        $this->name = (!is_array($session_config['name']))?$session_config:$session_config['name'];
        $this->session = new stdClass();
        $this->LoadSession();
        // Setup defaults if necessary
        if($this->Get('carbon_sess_conf') == '') {
            $this->Add('carbon_sess_conf',$session_config); 
        }
        // End setup defaults
        $this->ClearFlashSession();
    }

    /**
     * Loads and unserializes an existing session
     */
    private function LoadSession() {
        $this->session = unserialize($_SESSION[''.$this->name]);
        $this->flash = $this->session->_flash;
        unset($this->session->_flash);
    }

    /**
     * Checks if session contains a value for $key
     * @param string $key
     * @return bool
     */
    public function Has($key) {
        return (isset($this->session->$key));
    }

    /**
     * Adds a $value to the Session. It can be accessed via the $key.
     * @param string $key
     * @param mixed $value
     */
    public function Add($key,$value) {
        $this->session->$key = s($value);
        $this->Set();
    }

    /**
     * Retrieve the value of a session variable
     * @param string $key
     * @return mixed
     */
    public function Get($key) {
        return $this->session->$key;
    }

    /**
     * Remove a value from the session.
     * @param string $key
     */
    public function Remove($key) {
        unset($this->session->$key);
    }

    /**
     * Removes all values from the session
     */
    public function Clear() {
        $_SESSION[''.$this->name] = null;
        $this->session = null;
    }

    /**
     * Works like Add, but for Flash sessions
     * @param string $key
     * @param mixed $value
     * @see SessionManager::Add()
     */
    public function Flash($key,$value) {
        $this->session->_flash->$key = $value;
        $this->Set();
    }

    /**
     * Get a value from the last Flash session
     * @param string $key
     * @return mixed
     */
    public function GetFromFlash($key) {
        return $this->session->flash->$key;
    }

    /**
     * Sets the session object to $_SESSION after serialization
     */
    private function Set() {
        $_SESSION[''.$this->name] = serialize($this->session);
    }

    /**
     * Public method to clear the FlashSession manually. 
     */
    public function ClearFlashSession() {
        $this->Remove('_flash');
        $this->Set();
    }
}
?>

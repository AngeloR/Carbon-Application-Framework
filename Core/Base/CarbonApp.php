<?php
/**
 * @package Core
 * @subpackage Base
 * @author xangelo
 */
/**
 * Description of CarbonApp is the base Carbon object that provides access to
 * Module loading
 */
class CarbonApp {

    private $config;
    private static $instance;

    /**
     * Create an instance of CarbonApp
     */
    private function __construct() {
        $this->config = require_once('CarbonConfig.php');
    }

    /**
     * Get the current instance of CarbonApp
     *
     * Since CarbonApp can only REALLY exist in one instance, we've made the
     * constructor private and instead provide GetInstance() to retrieve an instance
     * of CarbonApp.
     *
     * @return CarbonApp
     */
    public static function GetInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new CarbonApp();
        }
        return self::$instance;
    }
    
    /**
     * Allows you to load a module with $name that conforms to
     * CarbonModule specifications.
     * 
     * Passes $args as an argument and can henceforth be called internally via
     * $this->$id or $this->$name if $id is not assigned
     * 
     * @param srting $name
     * @param array $args
     * @param srting $id
     * @return Object Instance of whatever module is being loaded
     */
    public static function LoadModule($name, $args = '') {
        using('Module.'.$name);
        $init = $name.'_init';
        return $init($args);
    }

    /**
     * This method is used as a handy bypass for $config within
     * a Controller. Since we're loading the $config anyways,
     * this method allows us to traverse it in the same way as using(), but
     * without the cache
     *
     * <b>Example: </b> Config('db.dev.host') will return the host of the dev configuration in db
     *
     * @param string $key A dot.delimited path to a key
     * @return mixed
     *
     */
    public function Config($key,$in = '') {
        if($in == '') {
            $in = $this->config;
        }
        $x = explode('.',$key);
        if(array_key_exists($x[0],$in)) {
            if(count($x) > 1) {
                $g = $x[0];
                array_shift($x);
                return $this->Config(implode('.',$x),$in[$g]);
            }
            else {
                return $in[$key];
            }
        }
    }
}
?>

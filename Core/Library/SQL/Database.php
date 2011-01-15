<?php
/**
 * @package SQL
 * @author xangelo
 */
/**
 * Allows for initialization of various Database drivers
 *
 * This is the actual database interaction class. Although there are various database
 * classes provided, they all implment IDatabase which provides a standard public
 * interface. Each Database class is then free to add their own methods and features
 * that may be considered engine specific.
 *
 * We provide the standard Database factory to allow modules to be cross-install
 * compatible. Instead of accessing a Mysql class, you would simply access
 * the Database class instead, which will ensure that the necessary files are all
 * loaded and ready to go.
 */
class Database {

    private $instance;

    /**
     * Right now the Database class only accepts mysql as a valid engine
     * type, but with time I wish to add mssql and various other database
     * engines. It returns a DatabaseObject based on the engine, but that
     * conforms to IDatabase allowing easy db switching.
     * 
     * @param array $config
     * @return Object
     * @see IDatabase
     */
    public function __construct($config) {
        if($this->instance == null) {
            if(array_key_exists('db_engine',$config)) {
                $db_engine = $config['db_engine'];
                unset($config['db_engine']);
            }

            switch(strtolower($db_engine)) {
                case 'mysql':
                    using('Core.Library.SQL.Mysql');
                    $this->instance = new Mysql($config);
                    break;
                default:
                    die('Unknown engine specified: '.$config['db_engine']);
                    break;
            }
        }
        return $this->instance;
    }

    /**
     * Get the existing instance of the current database.
     * @param array $config
     * @return Database
     */
    public static function GetInstance(array $config) {
        if($this->instance != null) {
            return $this->instance;
        }
        else {
            $config = using('CarbonConfig');
            return new Database($config);
        }
    }
}
?>

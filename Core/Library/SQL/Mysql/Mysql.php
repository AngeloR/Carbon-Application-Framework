<?php
/**
 * @package SQL
 * @subpackage Mysql
 * @author xangelo
 */
using('Core.Library.SQL',true,__FILE__);
/**
 * Mysql driver for database interactions
 *
 * Provides basic findBy methods for extending classes. Will return
 * either a Row or RowCollection. Ideally you would create your entity classes
 * and either extend the Mysql class or get an instance of the Mysql class by
 * calling Mysql::GetInstance();
 * 
 * Since no returned content is stored within a class, you don't end up
 * polluting between requests.
 * @see IDatabase
 */



class Mysql implements IDatabase{
    private $link;
    private $config;
    
    /**
     * Creates a connection to the database with $db_details
     * @param array $db_details 
     * @example 
     * 
     * $db = new MySqlBase(array(
     *  'host' => 'localhost',
     *  'user' => 'root',
     *  'pass' => '',
     *  'db' => 'my_db'
     * ));
     */
    public function __construct(array $db_details) {
        $error = false;
        if(!array_key_exists('host',$db_details)) {
            $error = true;
        }

        if(!array_key_exists('user',$db_details)) {
            $error = true;
        }

        if(!array_key_exists('pass',$db_details)) {
            $error = true;
        }

        if(!array_key_exists('db',$db_details)) {
            $error = true;
        }

        if(!$error) { //Go ahead with code
            $this->link = mysql_connect($db_details['host'],$db_details['user'],$db_details['pass']);
            if($this->link) {
                if(mysql_select_db($db_details['db'], $this->link) or error('Requested database does not exist')) {
                    $c = array(
                        'active_record' => false,
                    );
                    $this->Config($c);
                    return true;
                }
                else {
                    $this->Close();
                    return false;
                }
            }
        }
        else {

        }
    }

    /**
     * Sets up defaults for the database after construction
     * @param array $array
     */
    public function Config(array $array) {
        $this->config['active_record'] = $array['active_record'] || false;

        if($this->config['active_record']) {
            using('Core.Library.SQL.Mysql.ActiveRow');
        }
    }

    public static function GetInstance() {
        
    }

    /**
     * Closes any open Mysql connection
     */
    public function Close() {
        if($this->c) {
            mysql_close($this->c); 
        }
    }

    /**
     * Checks if there is currently an open connection
     * @return bool
     */
    public function IsConnectionOpen() {
        return ($this->link);
    }

    /**
     * Executes a query and returns a RowCollection object with the requested
     * results. Imports Collection.RowCollection by default
     *
     * @param string $sql
     * @return RowCollection $RowCollection Returns a collection object with the Rows
     */
    public function Execute($sql) {
        if($this->IsConnectionOpen()) {
            $q = mysql_query($sql) or error(mysql_error());
            if($q) {
                $RowCollection = new RowCollection();
                while($r = mysql_fetch_assoc($q)) {
                    if($this->config['active_record']) {
                        $Row = new ActiveRow();
                    }
                    else {
                        $Row = new Row();
                    }
                    foreach($r as $field=>$value) {
                        $Row->$field = $value;
                    }
                    $RowCollection->AddRow($Row);
                }
                return $RowCollection;
            }
        }
    }

    /**
     * Executes a query that does not return a result set
     * @param string $sql
     * @return bool
     */
    public function ExecuteNonQuery($sql) {
        if($this->IsConnectionOpen()) {
            $q = mysql_query($sql) or error(mysql_error());
            if($q) {
                return true;
            }
            return false;
        }
    }
}
?>

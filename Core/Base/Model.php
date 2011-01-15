<?php
/**
 * @author xangelo
 * @package Core
 * @subpackage Base
 */
/**
 * Default Model object (M from MVC)
 *
 * @author xangelo
 */
class Model {
    private $db;

    public function Init($db_config) {
        $this->db = $db_config; 
    }

    public function UseDatabase() {
        using('Core.Library.SQL');
        $this->db = new Database($db_config[$db_config['use']]);
    }
}
?>

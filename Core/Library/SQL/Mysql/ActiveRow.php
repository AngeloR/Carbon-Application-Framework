<?php
/**
 * @package SQL
 * @subpackage Mysql
 * @author xangelo
 */
/**
 * ActiveRow is the Mysql implementation of the ActiveRecord interface. It replaces
 * the standard Row object, but only works with Mysql.
 *
 * @see IActiveRecord
 */
using('Core.Base.IActiveRecord');
class ActiveRow implements IActiveRecord{
    private $data;

    /**
     * An easy way to implement variable property value selection
     * @param mixed $field
     * @return mixed
     */
    public function __get($field) {
        return $this->data[$field];
    }

    /**
     * An easy way to implement variable property assignment
     * @param mixed $field
     * @param mixed $value
     */
    public function __set($field,$value) {
        $this->data[$field] = $value;
    }

    /**
     * Saves the current Row data to the database
     */
    public function Save() {
        echo 'Row Saved';
    }

    /**
     * Deletes the current Row data from the database
     */
    public function Delete() {
        echo 'Row Deleted';
    }
}
?>

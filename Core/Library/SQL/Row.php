<?php
/**
 * @package SQL
 * @author xangelo
 */
/**
 * Object representing a single row in a database
 * 
 * The standard Row object. Currently it is simply a parser for an
 * Array, but you would extend Row when creating your entities so that
 * you were guaranteed to work with a RowCollection.
 */

class Row {
    private $data;

    public function __get($field) {
        return $this->data[$field];
    }

    public function __set($field,$value) {
        $this->data[$field] = $value; 
    }
}
?>

<?php
/**
 * @author xangelo
 * @package Core
 * @subpackage Base
 */

/**
 * The ActiveRecord interface is just used as a base for other objects.
 * If your Object implements the active record class, then you know
 * that you can directly call Save() and Delete() methods without
 * knowing how the insides work. It is up to the creator of the class to
 * provide implementation for these classes.
 */
interface IActiveRecord {

    /**
     * @return bool
     */
    public function Save();

    /**
     * @return bool;
     */
    public function Delete();
}
?>

<?php
/**
 * @package SQL
 * @author xangelo
 */
/**
 * Provides a standard interface for database drivers to conform to
 *
 * The IDatabase interface ensures that all databases will provide SOME
 * standard methods. As long as a module is utilizing these methods, and the database
 * class implements IDatabase, you will be able to access whatever database the user
 * is currently using.
 */
interface IDatabase {

    public function __construct(array $db_details);
    public function Config(array $array);
    public function Close();
    public static function GetInstance();
    public function IsConnectionOpen();
    public function Execute($sql);
    public function ExecuteNonQuery($sql);
}
?>

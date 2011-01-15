<?php
/**
 * @package FormManager
 * @author xangelo
 */
/**
 * Standard form element interface. All Form elements (except for the special
 * Form class) will implement this interface. 
 */
interface IFormElement {

    /**
     * Creates the object with name and assigns it a type
     *
     * @param string $name
     * @param string $type
     */
    public function __construct($name,$type);

    /**
     * Ensures that $type is valid for the object
     * 
     * @param string $type
     * @return bool
     */
    public function IsValidType($type);

    /**
     * Creates an HTML string that represents the Form element
     *
     * @return string
     */
    public function Render();
}
?>

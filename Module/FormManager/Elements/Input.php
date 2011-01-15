<?php
/**
 * @package FormManager
 * @subpackage Elements
 * @author xangelo
 */
/**
 * Creates a Form Input Element of type (text|hidden|password)
 *
 * Allows you to use the FormManager to create input elements dynamically.
 */
class Input extends FormElement implements IFormElement{

    /**
     * Create an Input with a name and type
     *
     * Creates a Form Input Element with the specified name and type
     *
     * @param string $name
     * @param string $type
     */
    public function __construct($name,$type) {
        $this->SetAttribute('name',$name);
        $this->SetAttribute('id',$name);
        if($this->IsValidType($type)) {
            $this->SetAttribute('type',$type);
        }
    }
    
    public function  SetText($t) {
        $this->SetAttribute('value',$t);
        parent::SetText($t);
    }

    public function  GetText() {
        parent::GetText();
    }

    /**
     * Set's the displayed value of the field
     * 
     * @param string $value
     */
    public function SetValue($value) {
        $this->SetAttribute('value', $value);
    }

    /**
     * Returns the unsanitized value from the field
     * 
     * @return string
     */
    public function GetValue() {
        return $this->GetAttribute('value');
    }

    /**
     * Ensures that only Inputs of type 'text','password', and 'hidden' can be created
     * @param string $type
     * @return bool
     */
    public function IsValidType($type) {
        return in_array(strtolower($type),array('text','password','hidden'));
    }

    /**
     * Creates an HTML representation of the input object
     * @return string
     */
    public function Render() {
        return '<input'.$this->RenderAttributes().'>';
    }

}
?>

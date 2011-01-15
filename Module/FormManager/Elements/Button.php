<?php
/**
 * @package FormManager
 * @subpackage Elements
 * @author xangelo
 */
/**
 * Creates buttons of type 'submit','reset'
 *
 * Allows you to use the FormManager to dynamically create buttons
 */
class Button extends FormElement implements IFormElement{

    /**
     * Create a button and assign it a name and type
     * @param string $name
     * @param string $type
     */
    public function __construct($name,$type) {
        $this->SetAttribute('name',$name);
        $this->SetAttribute('id',$name);
        if($this->IsValidType($type)) {
            $this->SetAttribute('type',$type);
        }
        $this->SetText($name);
    }

    /**
     * Ensures only buttons of type submit and reset are valid
     * @param string $type
     * @return bool
     */
    public function IsValidType($type) {
        return in_array(strtolower($type),array('submit','reset'));
    }

    /**
     * Create an HTML representation of the button object
     * @return string
     */
    public function Render() {
        $tmp = '<button'.$this->RenderAttributes();
        $tmp .= '>'.$this->GetText().'</button>';

        return $tmp;
    }

}
?>

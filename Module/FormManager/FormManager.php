<?php
/**
 * @package FormManager
 * @author xangelo
 */
using('Module.FormManager.FormElement');
/**
 * The form manager deals with implementing and maniuplating form and form data.
 * Forms can be created and an unlimited number of elements with unique names
 * are added to them. The forms can be rendered with Render() or each individual
 * element can be accessed via the name ascribed to it. 
 */

class FormManager extends FormElement{

    public $Values;
    private $Elements;

    /**
     * Creates a basic Form Manager and includes the Button Element class
     * by default.
     * 
     * @param array $args
     */
    public function __construct($name,$action) {
        // Load some defaults
        
        using('Module.FormManager.IFormElement');
        using('Module.FormManager.Elements.Button');
        
        
        $this->SetAttribute('name',$name);
        $this->SetAttribute('method','POST');
        $this->SetAttribute('action',$action);
    }

    /**
     * Gets all the values from a submitted form (via post) and adds it to
     * the Values object.
     *
     * TODO: Tie in File-uploading to this section
     */
    public function GetFormValues() {
        /**
         * Check to see if we have a form submitted. If we do, we save all the
         * values and store it.
         */
        if(count($_POST) > 0) {
            $this->Values = new stdClass();
            foreach($_POST as $k => $v) {
                $this->Values->$k = $v;
            }
        }
    }

    /**
     * Since, there can only be unique names and id's within a form, you can
     * directly access them via $this->{form_name}->{element_name}
     * 
     * @param string $name
     * @param string $type
     */
    public function Input($name,$type) {
        $this->ElementFactory('Input',$name,$type);
        
    }

    /**
     * Creates a Button with $name and $type
     * @param string $name
     * @param string $type
     */
    public function Button($name,$type) {
        $this->ElementFactory('Button',$name,$type);
    }

    /**
     * Creates a submit button for use with the form.
     * 
     * @param string $text Text to appear on the button
     */
    public function CreateSubmitButton($text) {
        $this->ElementFactory('Button','submit','submit');
        array_pop($this->Elements);
        $this->submit->SetText($text);
        $this->submit->SetAttribute('id',$this->GetAttribute('name').'_submit');
    }

    /**
     * Creates an element of type $element and passes a
     * name and type to it.
     * 
     * @param string $element
     * @param string $name
     * @param string $type
     */
    public function ElementFactory($element,$name,$type) {
        using('Module.FormManager.Elements.'.$element);
        $this->$name = new $element($name,$type);
        $this->$name->SetAttribute('id',$this->GetAttribute('name').'_'.$name);
        $this->Elements[] = $name;
    }

    /**
     * Creates the HTML for the form
     *
     * @param string $full Declares whether a full or partial render is necessary.
     * Partial renders do not generate the elements.
     * @return string|array Depending of whether a full or partial Render is required
     */
    public function Render($full = true) {
        if($full) {
            $this->GenerateSubmitButton();
            $tmp = "\r\n<form".$this->RenderAttributes().">\r\n";
            foreach($this->Elements as $i=>$c) {
                $tmp .= $this->$c->Render()."\r\n";
            }

            $tmp .= '</form>';
        }
        else {
            $tmp = array();
            $tmp[] = "\r\n<form".$this->RenderAttributes().">\r\n";
            $tmp[] = '</form>';
        }
        return $tmp;
    }

    /**
     * By default you never need to create the submit button, but you CAN by
     * calling CreateSubmitButton($name);
     */
    private function GenerateSubmitButton() {
        if(!isset($this->submit)) {
            $this->submit = new Button('submit','submit');
            $this->Elements[] = 'submit';
            $this->submit->SetText('Submit');
            $this->submit->SetAttribute('id',$this->GetAttribute('name').'_submit');
        }
        else {
            $this->Elements[] = $this->submit->GetAttribute('name');
        }
    }
}
?>

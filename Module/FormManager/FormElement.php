<?php
/**
 * @package FormManager
 * @author xangelo
 */
/**
 * All form elements will have these methods available to them.
 */
abstract class FormElement {

    private $text;
    private $attrs;
    private $name;

    /**
     * Set the text of the element
     *
     * Each element has a different use for Text. Inputs use Set text as an
     * alternate method to set the value field. Buttons use Set text as a way to
     * set the text that the button displays.
     * @param string $t
     */
    public function SetText($t) {
        $this->text = $t;
    }

    /**
     * Return the text of the element
     *
     * Each element uses the text field differently. Inputs use Get text as an
     * alternate method to get the value of an input. Buttons use Get text as a way
     * to get the text that the button displays.
     * @return string
     */
    public function GetText() {
        return $this->text;
    }

    /**
     * Set an attribute of the element
     * 
     * @param string $attr
     * @param mixed $value
     */
    public function SetAttribute($attr,$value) {
        $this->attrs[$attr] = $value;
    }

    /**
     * Get the value of an attribute 
     * @param string $attr
     * @return mixed
     */
    public function GetAttribute($attr) {
        return $this->attrs[$attr];
    }

    /**
     * Create an HTML representation of the attributes assigned to an element
     * @return string
     */
    public function RenderAttributes() {
        $tmp = '';
        foreach($this->attrs as $a=>$v) {
            $tmp .= ' '.$a.'="'.$v.'"';
        }
        return $tmp;
    }
}
?>

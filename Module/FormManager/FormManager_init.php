<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function FormManager_init($args) {
    $args = func_get_args();
    $name = ($args[0] == '')?'myform':$args[0];
    $action = ($args[1] == '')?'./index.php?'.$_SERVER['QUERY_STRING']:'./index.php?q='.$args[1];

    return new FormManager($name,$action);
}
?>

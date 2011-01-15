<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function Smarty_init() {

    $s = new Smarty;
    $base_dir = dirname(__FILE__).'/';
    $s->template_dir = $base_dir.'templates/';
    $s->compile_dir = $base_dir.'templates_c/';
    $s->cache_dir = $base_dir.'cache/';
    $s->config_dir = $base_dir.'configs/';
    return $s;
}
?>

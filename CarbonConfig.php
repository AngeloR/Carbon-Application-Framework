<?php
/**
 * This is the configuration file the the Carbon Application Framework. It is a
 * simple multi-dimensional associative(hash) array that contains various configuration
 * options for the Framework.
 *
 * @package Core
 * @author xangelo
 */

$config = array(
    'db' =>  array(
        'dev' => array(
            'host'  => 'localhost',
            'user'  => 'root',
            'pass'  => '',
            'db'    => 'cdcol',
            'db_engine' => 'mysql',
        ),

        'live' => array(

        ),

        'use' => 'dev',
    ),
    'session' => array(
        'name' => 'carbondata',
    ),
    // What module you want managing your logging. Leaving this empty disables
    // logging entirely
    'log_manager' => 'KLogger',

    // Any files that you want to be automatically included.
    'autoload' => array(),

    // Any modules that you want to be automatically loaded
    'autoinit' => array(),
);

return $config;
?>

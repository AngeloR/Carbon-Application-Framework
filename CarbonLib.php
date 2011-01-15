<?php
/**
 * Contains globally used functions.
 * 
 * The Carbon application framework makes use of the functions below to handle 
 * some base operations. They can be used from any file, and are included at 
 * the top of our index.php interaction point. They provide basic 
 * inclusion/cache operations as well as a shortcut to some commonly needed 
 * HTML methods. 
 * 
 * @package Core
 * @author xangelo
 */
/**
 * An inclusion with internal request cache.
 * 
 * Allows you to include files and entire directories. Allows you to have the benefit
 * of require_once while keeping the speed of include. The cache utilized in using
 * keeps directory included paths.
 *
 * When a <b>Path</b> is passed to using, it first checks to see if the path has already
 * been cached. If the <b>Path</b> has been cached, Carbon knows that all files
 * immediately within the directory are included. It then stops the request.
 *
 * If <b>Path</b> is not in the cache and is a directory, Carbon will list all
 * the .php files within the directory and call using_file().
 *
 * If <b>Path</b> is not a directory, using_file() is called right away.
 *
 * @param string $path A dot delimited path to a directory or file for inclusion (excluding .php extension)
 * @see using_file()
 */
function using($path_x) {
    // Set up include cache
    static $cache;
    if(!is_array($cache)) {
        $cache = array();
    }
    
    if($cache[$path_x]) {
        return;
    }
    
    // sanitize path
    $path = str_replace('.','/',$path_x);
    // Check if the path is a directory
    if(is_dir($path)) {
        $dh = opendir($path);
        if($dh) {
            while($i = readdir($dh)) {
                if(strpos($i.'','.php')) {
                    using_file($path.'/'.$i);
                }
            }
            closedir($dh);
            $cache[$path_x];
        }
    }
    else {
        using_file($path.'.php');
    }
}

/**
 * Includes a file once and only once
 *
 * The using_file method is used when you already know the absolute path
 * to a file and you only need a single file in a directory. It keeps it's
 * own cache of individual files to ensure that you don't end up with multiple
 * includes.
 *
 * @staticvar boolean $cache_2
 * @param string $file
 * @return null
 */
function using_file($file) {
    static $cache_2;
    if($cache_2[$file]) {
        return;
    }

    if(file_exists($file)) {
        $cache_2[$file] = true;
        include($file);
    }
    else {
        error('File does not exist');
    }
}

/**
 * Just a simple error handler. Think of it as "flash-error" It is only available
 * during page generation and then discarded.
 * 
 * @staticvar array $array
 * @param string $message
 * @param string $type
 */
function error($message,$type = 'error') {
    static $array;
    if($message == '') {
        return $array;
    }
    if(in_array(strtolower($type),array('error','debug'))) {
        $array[$type][] = $message;
        
    }
}

/**
 * A shortcut to creating links.
 *
 * By specifying links in this manner modifying URL's
 * becomes a simple matter of replacing this method. It contains nothing special, just
 * spitting back some standard HTML - but it is tiring to write over and over
 * 
 * @param string $to
 * @param string $text
 * @return string
 */
function l($to,$text) {
    return '<a href="./index.php?q='.$to.'">'.$text.'</a>';
}

/**
 * Sanize string
 *
 * This function is used as a shortcut to sanitize any string or array of strings.
 * It does no validation simply encodes special characters.
 * @param mixed $v
 * @return string
 */
function s($v) {
    if(is_array($v)) {
        $tmp = array();
        foreach($v as $i=>$k) {
            $tmp[$i] = s($k);
        }
        return $tmp;
    }
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8').'';
}
?>

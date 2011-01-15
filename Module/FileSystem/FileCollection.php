<?php
/**
 * @package FileSystem
 * @subpackage File
 * @author xangelo
 */
using('Core.Base.Collection');
/**
 * The FileCollection is a collection of all the files within a directory
 * path. The FileCollection does not allow for File manipulation, rather it
 * provides access to the FileObject() which allows for manipulation directly.
 *
 */

class FileCollection extends Collection{

    public function __construct() {
        $this->Init();
    }

    public function GetAll($path,$ext = '.') {
        if(is_dir($path)) {
            $dh = opendir($path);
            if($dh) {
                while($file = readdir($dh)) {
                    if($file != '.' && $file != '..' && strpos($file,$ext)) {
                        $f = new FileObject();
                        $f->Populate($path.'/'.$file);
                        $this->AddFile($f);
                    }
                }
            }
        }
    }

    public function AddFile(FileObject $f) {
        $this->Add($f);
    }
}
?>

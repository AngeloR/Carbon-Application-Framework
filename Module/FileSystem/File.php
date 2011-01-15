<?php
/**
 * @package FileSystem
 * @subpackage File
 * @author xangelo
 */
using('Core.Base.IActiveRecord');
/**
 * The FileObject allows you to easily manipulate a single file within the file 
 * system.
 *
 * The base File Object, so named to avoid collisions. It implements the ActiveRecord
 * interface, but does not allow you to put content within. By "saving" a file, you
 * can change the various attributes of the file as well as its location. Moving a
 * file will trigger the Save() method automatically
 *
 * @see IActiveRecord
 */
class FileObject implements IActiveRecord{

    /**
     * Name of the file
     * @var string
     */
    private $FileName;
    /**
     * Path to the file
     * @var string
     */
    private $FilePath;
    /**
     * File size in KB
     * @var int
     */
    private $FileSize;
    /**
     * Extension of the file
     * @var string
     */
    private $FileType;
    /**
     * Currently unused, will contain an array of file permissions
     * @var array
     */
    private $FilePermissions;

    public function FileName($n = '') {
        if($n != '') {
            $this->FileName = $n;
        }
        return $this->FileName;
    }

    public function SetFileSize($size = -1) {
        if($size < 0) {

        }
        else {
            $this->FileSize = $size;
        }
    }

    public function FilePage() {
        return $this->FilePath;
    }

    public function FileSize() {
        return $this->FileSize;
    }

    public function FileType() {
        return $this->FileType;
    }

    public function FilePermissions() {
        return $this->FilePermissions;
    }

    // Creates the file in the file system
    public function Save() {

    }

    // Removes the file from the file system
    public function Delete() {
        
    }

    public function Move($newPath) {
        
    }

    public function Populate($filepath) {
        $e = explode('/',$filepath);
        $this->FileName = ($e[count($e)-1]);
        array_pop($e);
        $this->FileSize = filesize($filepath);
        $x = explode('.',$e[count($e)-1]);
        $this->FileType = $x[count($x)-1];
        $this->FilePath = implode('/',$e);
        $this->FilePermissions = substr(sprintf('%o', fileperms($filepath)), -4);
    }
}
?>

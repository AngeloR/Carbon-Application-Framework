<?php
/**
 * @package FileSystem
 * @subpackage Directory
 * @author xangelo
 */

/**
 * Implements IActiveRecord
 * @see IActiveRecord
 */
using('Core.Base.IActiveRecord');

/**
 * The DirectoryObject allows you to easily manipulate a single directory within the
 * file system.
 *
 * The base Directory Object (named so because of PHP naming conflicts) allows
 * you to access various features of a Directory including the Path, Name and
 * Permissions.
 */
class DirectoryObject implements IActiveRecord{

    /**
     * The path to the directory not including itself.
     *
     * Path contains the path to a directory. If the directory is called mydir and
     * is located /path/to/mydir the Path variable will contain /path/to
     * @var string
     */
    private $Path;

    /**
     * Name of the directory
     * @var srting
     */
    private $Name;

    /**
     * Sets the default path.
     *
     * An absolute, or relative path is (optionally) supplied upon the construction
     * of the Directory Object. The relative path should be from the root directory
     * of the Carbon Application Framework.
     *
     * The path supplied is NOT verified at this point
     *
     * @param string $p
     */
    public function __construct($p = '') {
        $this->Path($p);
    }

    /**
     * Sets or Gets the Path
     *
     * By calling Path() you can get the string representation of the current
     * directory path. Optionally, by passing a new Path into the Directory Object
     * you can set the Path() after construction.
     *
     * The path supplied is NOT verified at this point.
     *
     * @param string $p
     * @return string
     */
    public function Path($p = '') {
        if($p != '') {
            $this->SetPath($p);
        }
        return $this->Path;
    }

    /**
     * Gets or Sets the name of a Directory
     *
     * By calling Name() you can supply a new name for the directory. Optionally,
     * by calling Name without any arguments, you can get the current name of the
     * directory.
     *
     * @param string $n
     * @return srting
     */
    public function Name($n = '') {
        if($n != '') {
            $this->Name = $n;
        }
        return $this->Name;
    }

    /**
     * Sets the path to a directory
     *
     * The path is only set if it is a valid directory location.
     *
     * @param srting $p
     */
    private function SetPath($p) {
        if($this->IsValid($p)) {
            $this->Path = $p;
        }
    }

    /**
     * Verifies the path.
     *
     * Parses through a the Path() to ensure that the Directory contains a
     * valid path of type 'dir'
     *
     * @param string $p
     * @return bool
     */
    public function IsValid($p) {
        $e = explode('/',$p); 
        if($e[count($e)-1] == '.' || $e[count($e)-1] == '..') {
            return false;
        }
        return filetype($p) === 'dir';
    }

    /**
     * Checks existence of directory
     *
     * If a path is supplied to Exists() it verfies if the current directory
     * exists at that location. If no argument is supplied, it checks to see
     * if there is a directory at the current set location.
     *
     * @param srting $p
     * @return bool
     */
    public function Exists($p = '') {
        if($p == '') {
            return (file_exists($this->Path().'/'.$this->Name()));
        }
        else {
            return file_exists($p.'/'.$this->Name());
        }
    }

    /**
     * Creates the directory at the current Path.
     *
     * @return bool
     * @see IActiveRecord::Save()
     */
    public function Save() {
        $p = $this->Path().'/'.$this->Name();
        if(!$this->Exists($p)) {
            return mkdir($p,0775,$force);
        }
    }

    /**
     * Deletes the directory from the current path
     *
     * Before deleting the directory, the method checks to see if there are any
     * files within that directory. If there are, it will fail.
     *
     * @return bool
     * @see IActiveRecord::Delete()
     */
    public function Delete() {
        $dc = new DirectoryCollection($this->Path().'/'.$this->Name());
        $dc->GetAll();
        if($dc->Size() == 0) {
            return (rmdir($this->Path().'/'.$this->Name()));
        }
        else {
            error('Could not remove directory '.$this->Name().', it contains, '.$dc->Size().' files!');
            return false;
        }
    }

    /**
     * Moves the directory to its new location
     *
     * Currently this method does nothing except return true. Directory moving has
     * not yet been implemented, however it is planned for a pre 0.5a release.
     *
     * @param string $new_loc
     * @return bool
     */
    public function Move($new_loc) {
        return true;
    }
}
?>

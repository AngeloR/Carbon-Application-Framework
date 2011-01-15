<?php
/**
 * @package FileSystem
 * @subpackage Directory
 * @author xangelo
 */

/**
 * Extends Collection
 * @see Collection
 */
using('Core.Base.Collection');
/**
 * The DirectoryCollection provides a directory listing for a single path.
 * It lists only directories as files are handled via the FileCollection class.
 * Because of the nature of the DirectoryObject, the DirectoryCollection does
 * not provide any manipulation features. Rather, the DirectoryCollection will
 * return a DirectoryObject which can be used.
 *
 * The DirectoryCollection is a FLAT REPRESENTATION. If you want a full
 * directory structure, please utilize the DirectoryListing class which is a
 * tree interface where each branch is a directory/file collection. 
 */
class DirectoryCollection extends Collection{

    /**
     * Contains the details of itsef.
     *
     * $self is the DirectoryObject representation of the location where the
     * DirectoryCollection is being opened.
     * @var DirectoryObject
     * @see DirectoryObject
     */
    private $self;

    /**
     * Contains the file collection of this directory
     * @var FileCollection
     * @see FileCollection
     */
    public $Files;

    /**
     * Creates and validates a new Directory Object based on the path.
     *
     * This creates the DirectoryObject and ensures that the path passed to it
     * is valid. It then creates the FilesCollection ojbect and runs Init()
     *
     * @param string $Path
     * @see FileCollection
     * @see Collection::Init()
     */
    public function __construct($Path) {
        $this->self = new DirectoryObject();
        
        if($this->self->IsValid($Path)) {
            $this->self->Path($Path);
            $this->Files = new FileCollection();
            $this->Init();
        }
    }

    /**
     * Get all contents of a directory (single-level)
     *
     * This method makes two calls, one to GetDirectories() and another to GetFiles().
     * These load the contents of the directory into their own collection objects.
     *
     * @see DirectoryCollection::GetDirectories()
     * @see DirectoryCollection::GetFiles()
     */
    public function GetAll() {
        $this->GetDirectories();
        $this->GetFiles();
    }

    /**
     * Get all directories within the directory (single-level)
     *
     * This will get the properties of every directory within the parent directory
     * and proceed to populate the DirectoryCollection with DirectoryObjects
     *
     * @see Directory
     */
    public function GetDirectories() {
        $d = opendir($this->self->Path());
        if($d) {
            while($file = readdir($d)) {
                if($this->self->IsValid($this->self->Path().'/'.$file)) {
                    $dir = new DirectoryObject();
                    $dir->Path($this->self->Path());
                    $dir->Name($file);
                    $this->AddDirectory($dir);
                }
            }
            closedir($d);
        }
    }

    /**
     * Adds a directory to the DirectoryCollection
     *
     * Adds a directory object to the directory collection
     *
     * @param DirectoryObject $d
     * @see Collection::Add();
     */
    public function AddDirectory(DirectoryObject $d) {
        $this->Add($d);
    }

    /**
     * Gets all the files within a directory
     *
     * Populates the FileCollection with FileObjects
     *
     * @see FileCollection::GetAll()
     */
    public function GetFiles() {
        $this->Files->GetAll($this->self->Path());
    }
}
?>

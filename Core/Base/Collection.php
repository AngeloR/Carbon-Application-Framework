<?php
/**
 * Collections are, essentially, arrays of something. In order to easily traverse
 * through these arrays the Collection object was built. A common naming convention
 * within Carbon is that if a class name contains Collection (as in DirectoryCollection,
 * RowCollection) it is extending the Collection object.
 *
 * @author xangelo
 * @package Core
 * @subpackage Base
 */

/**
 * Provides some basic methods for all Collections to use. When extended a call to
 * Collection->Init() MUST be made. This instantiates the various aspects of
 * the collection. Because of this necessity, your application should not contain 
 * a method called Init()
 * @see Collection::Init()
 */
abstract class Collection {
    
    private $Pointer;
    private $Size;
    private $Collection;

    private $Unique;

    /**
     * Creates the Collection
     *
     * This method is used so that extending objects can utilize the __construct()
     * method without overwriting it. Init() contains the basic Collection setup code.
     */
    protected function Init() {
        $this->Collection = array();
        $this->SetSize(0);
        $this->SetCurrentIndex($this->Size());
    }

    /**
     * Moves the internal pointer to the next available position
     */
    public function Next() {
        $this->SetCurrentIndex($this->GetCurrentIndex()+1);
    }

    /**
     * Moves the internal pointer to the previous available position
     */
    public function Prev() {
        $this->SetCurrentIndex($this->GetCurrentIndex()-1);
    }

    /**
     * Gets the current position of the pointer
     * @return int
     */
    public function GetCurrentIndex() {
        return $this->Pointer;
    }

    /**
     * Set the current position of the pointer
     * @param int $id
     */
    public function SetCurrentIndex($id) {
        if(is_int($id)) {
            $this->Pointer = $id;
        }
    }

    /**
     * Size of the collection
     * @return int Size of the collection
     */
    public function Size() {
        return $this->Size;
    }

    /**
     * Used to manually set the size of the collection. Normally this is completely
     * unnecessary, except during object creation.
     * 
     * @param int $int Set the size of the collection
     */
    protected function SetSize($int) {
        if(is_int($int)) {
            $this->Size = $int;
        }
    }

    /**
     * Check to see if there is an item at the current index
     * @return bool
     */
    public function HasItem() {
        return (!empty($this->Collection[$this->GetCurrentIndex()]));
    }

    /** 
     * Returns the item located at an Index. Does not move the
     * internal pointer.
     *
     * @param int $id
     * @return mixed
     */
    public function Seek($index) {
        return $this->Collection[$i] || null;
    }

    /**
     * Find the index of the item
     * @param mixed $item
     * @return int
     */
    public function GetIndex($item) {
        for($i = 0; $i < $this->Size(); ++$i) {
            if($this->Collection[$i] === $item) {
                return $i;
            }
        }
        return -1;
    }

    /**
     * Adds the item to the collection
     * @param mixed $item
     * @return bool
     */
    protected function Add($item) {
        if($this->GetIndex($item) >= 0) {
            return false;
        }
        $this->Collection[] = $item;
        $this->IncreaseSize();
        return true;
    }

    /**
     * Increases the size of the collection by 1.
     */
    private function IncreaseSize() {
        ++$this->Size;
    }

    /**
     * Removes an item at the specified index
     * @param int $index
     * @return bool
     */
    protected function RemoveByIndex($index) {
        if(is_int($index) && $index < $this->Size()) {
            ++$index;
            $pre = array_slide($this->Collection,0,$index);
            $post = array_slice($this->Collection,$index);

            $this->Collection = array_merge($pre,$post);
            return true;
        }
    }

    /**
     * Remove the specified item from the collection
     * @param mixed $item
     * @return bool
     */
    protected function RemoveByValue($item) {
        $index = $this->GetIndex($item);
        if($index >= 0) {
           return $this->RemoveByIndex($index);
        }
    }

    /**
     * Return the value at the current index
     * @return mixed
     */
    public function Read() {
        return $this->Collection[$this->GetCurrentIndex()];
    }

    /**
     * Toggle whether or not values in a collection
     * will remain unique
     */
    protected function Unique() {
        if($this->Unique) {
            $this->Unique = false;
        }
        else {
            $this->Unique =  true;
        }
    }
}
?>

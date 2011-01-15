<?php
/**
 * @package SQL
 * @author xangelo
 */
using('Core.Base.Collection');
using('Core.Library.SQL.Row');

/**
 * Represents a collection of Rows from the database
 *
 * Group of rows. Provides updated Iteration interface specific to the Row
 * collection. Most of the methods within the row collection are simply
 * references to the base Collection, but type casted to ensure that only
 * Rows are allowed into the collection from a collection.
 *
 * @see Collection
 * @see Row
 */
class RowCollection extends Collection {
    /**
     * Initaite the Collection and set each row to
     * Unique
     * @param bool $ar Implement active record or not
     */
    public function __construct() {
        $this->Init();
        $this->Unique();
    }

    /**
     * Add a new row to the collection
     * @param Row $row
     * @return bool
     */
    public function AddRow(Row $row) {
        return $this->Add($row);
    }

    /**
     * Return a Row that matches the specified Index
     * @param int $index
     * @return Row
     */
    public function GetRowByIndex($index) {
        return $this->Seek($index);
    }

    /**
     * Get the Index of the row specified
     * @param Row $row
     * @return int
     */
    public function GetRowIndex(Row $row) {
        return $this->GetIndex($row);
    }

    /**
     * Remove the Row that matches the specified index
     * @param int $index
     * @return bool
     */
    public function RemoveRowByIndex($index) {
        return $this->RemoveByIndex($index);
    }

    /**
     * Remove the Row that matches the supplied Row
     * @param Row $row
     * @return bool
     */
    public function RemoveRowByValue(Row $row) {
        return $this->RemoveByValue($row);
    }
}
?>

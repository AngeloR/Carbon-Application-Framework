<?php

/**
 * Models provide the basic business logic encapsulation
 *
 * @author xangelo
 */

class DefaultModel extends Model{

    public function __construct($config) {
        $this->Init($config);
    }

    public function GetCDs() {
        return 'Got CD\'s';
    }
}
?>

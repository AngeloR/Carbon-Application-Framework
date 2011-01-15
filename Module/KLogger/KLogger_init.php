<?php
/**
 * Creates an instance of KLogger
 *
 * All written modules should have a {$name}_init() function at the very top. This
 * function will be passed any required arguments as a zero-index array. This method
 * will simply parse that array out, pass the appropriate values and then will proceed
 * to return an instance of the class it is initiating.
 *
 * This function is required by ALL modules to ensure that any included library will
 * work right out of the box.
 *
 * @return KLogger
 */
function KLogger_init() {
    return new KLogger('./logs/', KLogger::INFO);
}
?>

<?php
/**
 * Schema
 *
 * Expressive table definitions
 *
 * @author 		Jamie Rumbelow <http://jamierumbelow.net>
 * @version		0.1.0
 * @copyright 	(c)2011 Jamie Rumbelow
 */

define('BASEPATH', true);

require_once 'libraries/Schema.php';

require_once 'tests/support/inferno/lib/inferno.php';
require_once 'tests/support/mocks.php';

class Schema_Test_Data {
    
    /* --------------------------------------------------------------
     * HELPER METHODS
     * ------------------------------------------------------------ */
     
    static public function mock_column_data() {
        return array('column_name' => array('type' => 'INT'));
    }
}
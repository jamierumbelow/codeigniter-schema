<?php
/**
 * Schema
 *
 * Expressive table definitions
 *
 * @author 		Jamie Rumbelow <http://jamierumbelow.net>
 * @version		0.0.1.alpha
 * @copyright 	(c)2011 Jamie Rumbelow
 */
 
require_once 'support/environment.php';

class Schema_Test extends UnitTest {
    
    /* --------------------------------------------------------------
     * FACTORY API TESTS
     * ------------------------------------------------------------ */
     
    public function test_create_table() {
        $ci =& get_instance();
        $ci->load = new Mock_Loader();
        $ci->dbforge = new Mock_DBForge();
        
        $ci->load->expect_call('dbforge');
        
        $ci->dbforge->expect_call('add_field', 1, $this->mock_column_data());
        $ci->dbforge->expect_call('create_table', 1, 'table_name');
        
        Schema::create_table('name', function(&$table){
            $table = new Mock_Schema_Test_Definition();
        });
        
        $ci->load->assert($this);
        $ci->dbforge->assert($this);
    }
     
    /* --------------------------------------------------------------
     * HELPER METHODS
     * ------------------------------------------------------------ */
     
    static public function mock_column_data() {
        return array('column_name' => array('type' => 'INT'));
    }
}

UnitTest::test();
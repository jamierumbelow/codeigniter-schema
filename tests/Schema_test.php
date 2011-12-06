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
            $table = new Mock_Schema_Test_Definition_Create_Table();
        });
        
        $ci->load->assert($this);
        $ci->dbforge->assert($this);
    }
    
    public function test_add_column() {
        $ci =& get_instance();
        $ci->load = new Mock_Loader();
        $ci->dbforge = new Mock_DBForge();
        
        $ci->load->expect_call('dbforge');
        $ci->dbforge->expect_call('add_column', 1, array('table_name', $this->mock_column_data()));
        
        Schema::add_column('table_name', 'column_name', 'integer');
        
        $ci->load->assert($this);
        $ci->dbforge->assert($this);
    }
    
    public function test_remove_column() {
        $ci =& get_instance();
        $ci->load = new Mock_Loader();
        $ci->dbforge = new Mock_DBForge();
        
        $ci->load->expect_call('dbforge');
        $ci->dbforge->expect_call('remove_column', 1, array('table_name', 'column_name'));
        
        Schema::remove_column('table_name', 'column_name');
        
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

if (!defined('SCHEMA_TEST_ALL')) {
    UnitTest::test();
}
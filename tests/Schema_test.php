<?php
/**
 * Schema
 *
 * Expressive table definitions
 *
 * @author 		Jamie Rumbelow <http://jamierumbelow.net>
 * @version		0.2.0
 * @copyright 	(c)2011 Jamie Rumbelow
 */
 
require_once 'support/environment.php';

class Schema_Test extends UnitTest {
    
    /* --------------------------------------------------------------
     * FACTORY API TESTS
     * ------------------------------------------------------------ */
     
    public function test_create_table_53() {
        $ci =& get_instance();
        $ci->load = new Mock_Loader();
        $ci->dbforge = new Mock_DBForge();
        
        $test =& $this;
        
        Schema::create_table('name', function($table) use (&$test) {
            $test->assert_class($table, 'Schema_Table_Definition');
        });
    }
    
    public function test_create_table_52() {
        $table = Schema::create_table('name', FALSE);
        $this->assert_class($table, 'Schema_Table_Definition');
    }
    
    public function test_add_column() {
        $ci =& get_instance();
        $ci->load = new Mock_Loader();
        $ci->dbforge = new Mock_DBForge();
        
        $ci->load->expect_call('dbforge');
        $ci->dbforge->expect_call('add_column', 1, array('table_name', Schema_Test_Data::mock_column_data()), array(), 'after_column');
        
        Schema::add_column('table_name', 'column_name', 'integer', array(), 'after_column');
        
        $ci->load->assert($this);
        $ci->dbforge->assert($this);
    }
    
    public function test_remove_column() {
        $ci =& get_instance();
        $ci->load = new Mock_Loader();
        $ci->dbforge = new Mock_DBForge();
        
        $ci->load->expect_call('dbforge');
        $ci->dbforge->expect_call('drop_column', 1, array('table_name', 'column_name'));
        
        Schema::remove_column('table_name', 'column_name');
        
        $ci->load->assert($this);
        $ci->dbforge->assert($this);
    }
    
    public function test_rename_column() {
        $ci =& get_instance();
        $ci->load = new Mock_Loader();
        $ci->dbforge = new Mock_DBForge();
        
        $ci->load->expect_call('dbforge');
        $ci->dbforge->expect_call('modify_column', 1, array('table_name', array('column_name' => array( 'name' => 'new_column_name'))));
        
        Schema::rename_column('table_name', 'column_name', 'new_column_name');
        
        $ci->load->assert($this);
        $ci->dbforge->assert($this);
    }
    
    public function test_modify_column() {
        $ci =& get_instance();
        $ci->load = new Mock_Loader();
        $ci->dbforge = new Mock_DBForge();
        
        $ci->load->expect_call('dbforge');
        $ci->dbforge->expect_call('modify_column', 1, array('table_name', array('column_name' => array( 'type' => 'INT', 'other' => 'here' ))));
        
        Schema::modify_column('table_name', 'column_name', 'integer', array( 'other' => 'here' ));
        
        $ci->load->assert($this);
        $ci->dbforge->assert($this);
    }
}

if (!defined('SCHEMA_TEST_ALL')) {
    UnitTest::test();
}
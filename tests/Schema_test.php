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

use Mockery as m;

class SchemaTest extends UnitTest {
    
    /* --------------------------------------------------------------
     * SCHEMA TABLE DEFINITION TESTS
     * ------------------------------------------------------------ */
    
    public function test_schema_table_definition__construct() {
        $schema_table_definition = new Schema_Table_Definition('table_name');
        $this->assert_equal($schema_table_definition->table_name(), 'table_name');
    }
    
    public function test_schema_table_definition_integer() {
        $mock_schema_table_definition = m::mock('Schema_Table_Definition[add_definition_rule]');
        $schema_table_definition = new Schema_Table_Definition('table_name');
        
        $mock_schema_table_definition->shouldReceive('add_definition_rule')->once()->with('column_name', array( 'type' => 'INT' ), array( 'option' => 'here' ));
        
        $mock_schema_table_definition->integer('column_name', array( 'option' => 'here' ));
        $schema_table_definition->integer('column_name', array( 'option' => 'here' ));
        
        $this->assert_equal($schema_table_definition->columns(), array(
            'column_name' => array('type' => 'INT', 'option' => 'here'))
        );
    }
            
    // Close Mockery
    public function tear_down() { 
        try {
            m::close();
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}

UnitTest::test();
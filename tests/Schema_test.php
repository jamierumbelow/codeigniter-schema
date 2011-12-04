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

class SchemaTest extends UnitTest {
    
    /* --------------------------------------------------------------
     * COLUMN API TESTS
     * ------------------------------------------------------------ */
    
    public function test_schema_table_definition_integer() {
        $schema_table_definition = new Schema_Table_Definition('table_name');
        $schema_table_definition->integer('column_name', array( 'option' => 'here' ));
        
        $this->assert_equal($schema_table_definition->columns(), array(
            'column_name' => array('type' => 'INT', 'option' => 'here'))
        );
    }
    
    public function test_schema_table_definition_auto_increment_integer() {
        $schema_table_definition = new Schema_Table_Definition('table_name');
        $schema_table_definition->auto_increment_integer('column_name', array( 'option' => 'here' ));
        
        $this->assert_equal($schema_table_definition->columns(), array(
            'column_name' => array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'option' => 'here'))
        );
    }
    
    public function test_schema_table_definition_string() {
        $schema_table_definition = new Schema_Table_Definition('table_name');
        $schema_table_definition->string('column_name', 100, array( 'option' => 'here' ));
        
        $this->assert_equal($schema_table_definition->columns(), array(
            'column_name' => array('type' => 'VARCHAR', 'constraint' => 100, 'option' => 'here'))
        );
    }
    
    public function test_schema_table_definition_text() {
        $schema_table_definition = new Schema_Table_Definition('table_name');
        $schema_table_definition->text('column_name', array( 'option' => 'here' ));
        
        $this->assert_equal($schema_table_definition->columns(), array(
            'column_name' => array('type' => 'TEXT', 'option' => 'here'))
        );
    }
    
    public function test_schema_table_definition_date() {
        $schema_table_definition = new Schema_Table_Definition('table_name');
        $schema_table_definition->date('column_name', array( 'option' => 'here' ));
        
        $this->assert_equal($schema_table_definition->columns(), array(
            'column_name' => array('type' => 'DATE', 'option' => 'here'))
        );
    }
    
    public function test_schema_table_definition_datetime() {
        $schema_table_definition = new Schema_Table_Definition('table_name');
        $schema_table_definition->datetime('column_name', array( 'option' => 'here' ));
        
        $this->assert_equal($schema_table_definition->columns(), array(
            'column_name' => array('type' => 'DATETIME', 'option' => 'here'))
        );
    }
    
    public function test_schema_table_definition_timestamps() {
        $schema_table_definition = new Schema_Table_Definition('table_name');
        $schema_table_definition->timestamps();
        
        $this->assert_equal($schema_table_definition->columns(), array(
            'created_at' => array('type' => 'DATETIME'),
            'updated_at' => array('type' => 'DATETIME')
        ));
    }
    
    /* --------------------------------------------------------------
     * MISC API TESTS
     * ------------------------------------------------------------ */
     
    public function test_schema_table_definition__construct() {
        $schema_table_definition = new Schema_Table_Definition('table_name');
        $this->assert_equal($schema_table_definition->table_name(), 'table_name');
    }
     
    public function test_schema_table_definition_primary_key() {
        $schema_table_definition = new Schema_Table_Definition('table_name');
        $schema_table_definition->primary_key('column_name');
        
        $this->assert_equal($schema_table_definition->keys(), array('column_name' => TRUE));
    }
    
    public function test_schema_table_definition_key() {
        $schema_table_definition = new Schema_Table_Definition('table_name');
        $schema_table_definition->key('column_name');
        
        $this->assert_equal($schema_table_definition->keys(), array('column_name' => FALSE));
    }
    
    public function test_schema_table_definition_add_definition_rule() {
        $schema_table_definition = new Schema_Table_Definition('table_name');
        $schema_table_definition->add_definition_rule('column_name', array('type' => 'INT'), array('opts' => 'here'));
        
        $this->assert_equal($schema_table_definition->columns(), array('column_name' => array('type' => 'INT', 'opts' => 'here')));
    }
}

UnitTest::test();
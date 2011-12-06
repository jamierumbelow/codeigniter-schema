<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Schema
 *
 * Expressive table definitions
 *
 * @author 		Jamie Rumbelow <http://jamierumbelow.net>
 * @version		0.0.1.alpha
 * @copyright 	(c)2011 Jamie Rumbelow
 */

/* --------------------------------------------------------------
 * THE SCHEMA FACTORY CLASS
 * ------------------------------------------------------------ */
 
class Schema {
    
    /* --------------------------------------------------------------
	 * VARIABLES
	 * ------------------------------------------------------------ */
	 
	static public $types = array( 'integer' => 'INT', 'string' => 'VARCHAR', 'text' => 'TEXT', 'date' => 'DATE', 'datetime' => 'DATETIME' );
    
    /* --------------------------------------------------------------
	 * GENERIC METHODS
	 * ------------------------------------------------------------ */
	 
	public function __construct() { }
	
	/* --------------------------------------------------------------
	 * FACTORY API
	 * ------------------------------------------------------------ */
    
    static public function create_table($table_name, $callback) {
        $table_definition = new Schema_Table_Definition($table_name);
        $callback($table_definition);
        
        $ci =& get_instance();
        $ci->load->dbforge();
        
        $ci->dbforge->add_field($table_definition->columns());
        
        foreach ($table_definition->keys() as $key => $primary) {
            $ci->dbforge->add_key($key, $primary);
        }
        
        $ci->dbforge->create_table($table_definition->table_name());
    }
    
    static public function add_column($table, $type, $name, $options = array()) {
        $column = array();
        
        if (isset(self::$types[$type]))
        {
            $column = array( 'type' => self::$types[$type] ); 
        } 
        elseif ($type == 'auto_increment_integer')
        {
            $column = array( 'type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE );
        }
        elseif ($type == 'timestamps')
        {
            self::add_column($table, 'datetime', 'created_at');
            self::add_column($table, 'datetime', 'updated_at');
            
            return;
        }
        
        $ci =& get_instance();
        $ci->load->dbforge();
        
        $ci->dbforge->add_column($table, array($name => array_merge($column, $options)));
    }
}

/* --------------------------------------------------------------
 * SCHEMA TABLE DEFINITION CLASS
 * ------------------------------------------------------------ */

class Schema_Table_Definition {

    /* --------------------------------------------------------------
	 * VARIABLES
	 * ------------------------------------------------------------ */
    
    protected $name = '';
    protected $definition = array(
        'columns' => array(),
        'keys' => array()
    );
    
    /* --------------------------------------------------------------
	 * GENERIC METHODS
	 * ------------------------------------------------------------ */

    public function __construct($table_name = '') {
        $this->name = $table_name;
    }

    /* --------------------------------------------------------------
	 * GENERIC API
	 * ------------------------------------------------------------ */
    
    public function columns() {
        return $this->definition['columns'];
    }
    
    public function keys() {
        return $this->definition['keys'];
    }
    
    public function table_name() {
        return $this->name;
    }
    
    /* --------------------------------------------------------------
	 * COLUMN API
	 * ------------------------------------------------------------ */
    
    public function integer($column_name, $options = array()) {
        $this->add_definition_rule($column_name, array(
            'type' => 'INT'
        ), $options);
    }
    
    public function auto_increment_integer($column_name, $options = array()) {
        $this->integer($column_name, array_merge(array(
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ), $options));
        
        $this->key($column_name, TRUE);
    }
    
    public function string($column_name, $constraint = 200, $options = array()) {
        $this->add_definition_rule($column_name, array(
            'type' => 'VARCHAR',
            'constraint' => $constraint
        ), $options);
    }
    
    public function text($column_name, $options = array()) {
        $this->add_definition_rule($column_name, array(
            'type' => 'TEXT'
        ), $options);
    }
    
    public function date($column_name, $options = array()) {
        $this->add_definition_rule($column_name, array(
            'type' => 'DATE'
        ), $options);
    }
    
    public function datetime($column_name, $options = array()) {
        $this->add_definition_rule($column_name, array(
            'type' => 'DATETIME'
        ), $options);
    }
    
    public function timestamps($options = array()) {
        $this->datetime('created_at', $options);
        $this->datetime('updated_at', $options);
    }
    
    /* --------------------------------------------------------------
	 * MISC API
	 * ------------------------------------------------------------ */
    
    public function primary_key($column_name) {
        $this->key($column_name, TRUE);
    }
    
    public function key($column_name, $primary = FALSE) {
        $this->definition['keys'][$column_name] = $primary;
    }
    
    public function add_definition_rule($column_name, $rule, $options) {
        $this->definition['columns'][$column_name] = array_merge($rule, $options);
    }
        
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Schema
 *
 * Expressive table definitions
 *
 * @author 		Jamie Rumbelow <http://jamierumbelow.net>
 * @version		0.2.0
 * @copyright 	(c)2011 Jamie Rumbelow
 */

/* --------------------------------------------------------------
 * THE SCHEMA FACTORY CLASS
 * ------------------------------------------------------------ */
 
class Schema {
    
    /* --------------------------------------------------------------
	 * VARIABLES
	 * ------------------------------------------------------------ */
	 
	static public $types = array(
		'integer' 	=> 'INT',
		'int'		=> 'INT',
		'bigint'	=> 'BIGINT',
        'decimal'   => 'DECIMAL',
		'string' 	=> 'VARCHAR', 
		'varchar'	=> 'VARCHAR',
		'char'		=> 'CHAR',
		'text' 		=> 'TEXT', 
        'longtext' 	=> 'LONGTEXT', 
		'date' 		=> 'DATE', 
		'datetime' 	=> 'DATETIME', 
		'boolean' 	=> 'TINYINT',
		'tinyint'	=> 'TINYINT'		
	);
    
    /* --------------------------------------------------------------
	 * GENERIC METHODS
	 * ------------------------------------------------------------ */
	 
	public function __construct() { }
	
	/* --------------------------------------------------------------
	 * FACTORY API
	 * ------------------------------------------------------------ */
    
    static public function create_table($table_name, $callback) {
        $table_definition = new Schema_Table_Definition($table_name);
        
        if ($callback === FALSE) {
            return $table_definition;
        } else {
            $callback($table_definition);
            $table_definition->create_table();
        }
    }
    
    static public function add_column($table, $name, $type, $options = array(), $after_column = '') {
        $column = array();
        
        if (isset(self::$types[strtolower($type)]))
        {
            $column = array( 'type' => self::$types[$type] ); 
        } 
        elseif ($type == 'auto_increment_integer')
        {
            $column = array( 'type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE );
        }
        elseif ($type == 'timestamps')
        {
            self::add_column($table, 'created_at', 'datetime');
            self::add_column($table, 'updated_at', 'datetime');
            
            return;
        }
        
        $ci =& get_instance();
        $ci->load->dbforge();
        
        $ci->dbforge->add_column($table, array($name => array_merge($column, $options)), $after_column);
    }
    
    static public function remove_column($table, $name) {
        $ci =& get_instance();
        $ci->load->dbforge();
        
        $ci->dbforge->drop_column($table, $name);
    }
    
    static public function rename_column($table, $name, $new_name) {
        $ci =& get_instance();
        $ci->load->dbforge();
        
        $field_data = $ci->db->field_data($table);
        $types = array();

        foreach ($field_data as $col)
        {
            $types[$col->name] = $col->type;
        }

        $ci->dbforge->modify_column($table, array( $name => array( 'name' => $new_name, 'type' => $types[$name] )));
    }
    
    static public function modify_column($table, $name, $type, $options = array()) {
        $column = array( 'type' => self::$types[strtolower($type)] );
        
        $ci =& get_instance();
        $ci->load->dbforge();
        
        $ci->dbforge->modify_column($table, array( $name => array_merge($column, $options) ));
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
    
    public function create_table() {
        $ci =& get_instance();
        $ci->load->dbforge();
        
        $ci->dbforge->add_field($this->columns());
        
        foreach ($this->keys() as $key => $primary) {
            $ci->dbforge->add_key($key, $primary);
        }
        
        $ci->dbforge->create_table($this->table_name());
    }
    
    /* --------------------------------------------------------------
	 * COLUMN API
	 * ------------------------------------------------------------ */
    
    public function integer($column_name, $options = array()) {
        $this->add_definition_rule($column_name, array(
            'type' => 'INT'
        ), $options);
    }
    
    public function tinyint($column_name, $options = array()) {
        $this->add_definition_rule($column_name, array(
            'type' => 'TINYINT'
        ), $options);
    }
    
    public function decimal($column_name, $constraint = '10,2', $options = array()) {
        $this->add_definition_rule($column_name, array(
            'type' => 'DECIMAL',
            'constraint' => $constraint,
            'unsigned'  => FALSE
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

    public function char($column_name, $constraint = 2, $options = array()) {
        $this->add_definition_rule($column_name, array(
            'type' => 'CHAR',
            'constraint' => $constraint
        ), $options);
    }

    public function text($column_name, $options = array()) {
        $this->add_definition_rule($column_name, array(
            'type' => 'TEXT'
        ), $options);
    }
    
    public function longtext($column_name, $options = array()) {
        $this->add_definition_rule($column_name, array(
            'type' => 'LONGTEXT'
        ), $options);
    }
    
    public function boolean($column_name, $options = array()) {
        $this->add_definition_rule($column_name, array(
            'type' => 'TINYINT'
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
# Schema

Schema allows you to write your migrations (and define your database tables) in pure, beautiful PHP. No more feeding the DBForge library raw SQL fragments or dumping and loading at the command line. Schema lets you design your database in your migrations with ultimate ease.

## Synopsis

```php
Schema::create_table('users', function($table){
    
    $table->auto_increment_integer('id');
    
    $table->string('email');
    $table->string('password');
    
    $table->string('first_name');
    $table->string('last_name');
    
    $table->text('biography');
    
    $table->timestamps();
});
```

## Requirements

Schema requires at minimum PHP 5.1.2 (although 5.3 is recommended) and CodeIgniter 2.0.0.

## Installation

Schema is easy to install using [CodeIgniter Sparks](http://getsparks.org). Simply install `schema`:

```bash
$ php tools/sparks install schema
```

...and load the Spark when you want to use it:

```php
$this->load->spark('schema');
```

Alternatively, you can download the repository through GitHub, extract the **libraries/Schema.php** and move it to the **application/libraries** directory. Then load it by calling `$this->load->library`.

## Creating Tables

The `Schema::create_table()` function allows you to define and create a table in one fell swoop. It takes two parameters: the table name as a string, and a closure function, or 'block', (which enables the nice schema defining DSL).

This function takes a single parameter, which is an instance of `Schema_Table_Definition`. You can then call methods on this object to define the schema for your database tables.

```php
Schema::create_table('users', function($table){
    // Definition goes in here
});
```

If you're not running PHP5.3, you can pass through `FALSE` (boolean) and `create_table()` will return the table object directly. Finish your statements with a call to `$table->create_table()`.

```php
$table = Schema::create_table('users', FALSE);

$table->string('name');
$table->create_table();
```

## Data Types

`Schema_Table_Definition` has a bunch of methods that allow you to create data types. These are all reasonably self-explanatory:

* `integer($name)` - create an INT column
* `string($name, $constraint = 200)` - create a VARCHAR column (with optional constraint)
* `text($name)` - create a TEXT column
* `date($name)` - create a DATE column
* `datetime($text)` - create a DATETIME column

There are also two special methods to speed up your development.

`auto_increment_integer($name)` allows you to specify an auto_increment INT (with required primary keys). This is most helpful for adding an id column:

```php
$table->auto_increment_integer('id');
```

`timestamps()` automatically generates two columns, `created_at` and `updated_at`, both `DATETIME` columns.

### Keys

You can add keys (indexes) through two functions, `primary_key($name)`, and `key($name, $primary = FALSE)`. `primary_key()` is a small wrapper around `key()`.

## Modifying Tables

Schema also contains a series of functions that allow you to modify an existing table.

### Add Columns

`Schema::add_column()` lets you add a column to an existing table very simply. It takes three parameters, the table name, the column name and the column data type.

```php
Schema::add_column('users', 'rank', 'integer');
```

### Remove Columns

`Schema::remove_column()` lets you remove a column from a database table.

```php
Schema::remove_column('users', 'rank');
```

### Rename Columns

`Schema::rename_column()` lets you rename a column in a database table.

```php
Schema::rename_column('users', 'rank', 'position');
```

### Modify Columns

`Schema::modify_column()` allows you to modify the type and properties of a column.

```php
Schema::modify_column('users', 'rank', 'string', array('constraint' => 250));
```

## Running Unit Tests

**NOTE: In order to run the test suite PHP5.3 is required**

Schema comes with a unit test suite to ensure that the software remains stable and refactorable. It uses the very simple and lightweight [PHP testing framework Inferno](https://github.com/jamierumbelow/inferno). Inferno is tucked away in a submodule:

```bash
$ cd path_to_schema_repo/
$ git submodule init
$ git submodule update
```

Then, all it takes is a call to **tests/all.php** to run the entire test suite.

```bash
$ php tests/run.php
```

You can also specify particular files in the suite by calling that file directly:

```bash
$ php tests/Schema_test.php
```
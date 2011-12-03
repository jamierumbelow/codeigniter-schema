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

Schema requires at minimum PHP5.3 and CodeIgniter 2.0.0.

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

## Running Unit Tests

Schema comes with a unit test suite to ensure that the software remains stable and refactorable. In order to run the unit tests, you'll need to install [PEAR](http://pear.php.net) and [Mockery](https://github.com/padraic/mockery).

Once they're installed, be sure to grab the submodules (this includes [Inferno](https://github.com/jamierumbelow/inferno), the testing framework).

```bash
$ cd path_to_schema_repo/
$ git submodule init
$ git submodule update
```

Then, all it takes is a call to **tests/Schema_test.php**!

```bash
$ php tests/Schema_test.php
```
# Schema

Schema allows you to define your database schema in pure, beautiful PHP. No more feeding the DBForge library raw SQL fragments or dumping and loading at the command line. Schema lets you design your database in your migrations with minimal ease.

# Synopsis

```php
Schema::create_table(function($table){
    
    $table->auto_increment_integer('id');
    
    $table->string('email');
    $table->string('password');
    
    $table->string('first_name');
    $table->string('last_name');
    
    $table->text('biography');
    
    $table->timestamps();
});
```
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

define('BASEPATH', true);

require_once 'libraries/Schema.php';
require_once 'tests/support/inferno/lib/inferno.php';

require_once 'Mockery/Loader.php';
$loader = new \Mockery\Loader;
$loader->register();
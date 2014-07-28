#!/usr/bin/php -q
<?php

require_once 'simpletest/autorun.php';
SimpleTest :: prefer(new TextReporter());
set_include_path('../php' . PATH_SEPARATOR . get_include_path());
require_once 'ISBN/Factory.php';

//error_reporting( E_STRICT );

class ISBNTest extends UnitTestCase
{
    function __construct()
    {
        $this->invalid_prefix_isbn = '1234567890123';
    }

    function test_isbn()
    {
        // TODO: Add exception type-checking!
        //$this->expectException('invalid prefix');
        $this->expectException();
        $isbn = ISBN_Factory::create( $this->invalid_prefix_isbn );
    }
}

?>

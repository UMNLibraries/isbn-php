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
        $this->isbn          = '9789607771278';
    }

    function test_isbn()
    {
        $isbn = ISBN_Factory::create( $this->isbn );
        $this->assertIsA($isbn, 'ISBN13');
        $this->assertEqual($isbn->as_string(array()), $this->isbn);

        $clone = $isbn->as_isbn13();
        $this->assertIsA($clone, 'ISBN13');
    }
}

?>

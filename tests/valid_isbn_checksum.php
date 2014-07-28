#!/usr/bin/php -q
<?php

require_once 'simpletest/autorun.php';
SimpleTest :: prefer(new TextReporter());
set_include_path('../php' . PATH_SEPARATOR . get_include_path());
require_once 'ISBN/Factory.php';

//error_reporting( E_STRICT );

class ISBNTest extends UnitTestCase
{
    function test_good_isbns()
    {
        $isbn = ISBN_Factory::create('0596527241');
        $this->assertIsA($isbn, 'ISBN10');

        $isbn = ISBN_Factory::create('9780596527242');
        $this->assertIsA($isbn, 'ISBN13');
    }

    function test_bad_isbn10()
    {
        $this->expectException();
        $isbn = ISBN_Factory::create('059652724X');
    }

    function test_bad_isbn13()
    {
        $this->expectException();
        $isbn = ISBN_Factory::create('9780596527243');
    }
}

?>

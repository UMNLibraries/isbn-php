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
        $this->good_isbn          = '9992701579';
        $this->good_isbn_string   = '99927-0-157-9';
        $this->group_code         = '99927';
        $this->publisher_code     = '0';
        $this->article_code       = '157';
        $this->checksum           = '9';
    }

    function test_isbn()
    {
        $isbn = ISBN_Factory::create( $this->good_isbn );
        $this->assertIsA($isbn, 'ISBN10');

        $this->assertEqual($isbn->group_code(), $this->group_code);
        $this->assertEqual($isbn->publisher_code(), $this->publisher_code);
        $this->assertEqual($isbn->article_code(), $this->article_code);
        $this->assertEqual($isbn->checksum(), $this->checksum);
        $this->assertEqual($isbn->as_string(), $this->good_isbn_string);
    }
}

?>

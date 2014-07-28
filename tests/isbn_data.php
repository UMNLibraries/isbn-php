#!/usr/bin/php -q
<?php

require_once 'simpletest/autorun.php';
SimpleTest :: prefer(new TextReporter());
set_include_path('../php' . PATH_SEPARATOR . get_include_path());
require_once 'ISBN/Data.php';

//error_reporting( E_STRICT );

class ISBNDataTest extends UnitTestCase
{
    function test_group_code_exists()
    {
        $this->assertTrue( ISBN_Data::group_code_exists('0') );
        $this->assertFalse( ISBN_Data::group_code_exists('bogus') );
    }

    function test_max_group_code_length()
    {
        // This will fail if the data changes to include longer codes!
        $length = ISBN_Data::max_group_code_length();
        $this->assertEqual($length, 5);
    }

    function test_publisher_ranges()
    {
        $english_group_code = '0';

/*
        $expected_english_group_data = array('English speaking area' => array(
            '00' => '19',
            '200' => '699',
            '7000' => '8499',
            '85000' => '89999',
            '900000' => '949999',
            '9500000' => '9999999',
        ));
        $english_group_data = $isbn->group_data( $english_group_code );
        $this->assertEqual($english_group_data, $expected_english_group_data);
*/
        $expected_english_publisher_ranges = array(
            '00' => '19',
            '200' => '699',
            '7000' => '8499',
            '85000' => '89999',
            '900000' => '949999',
            '9500000' => '9999999',
        );

        $english_publisher_ranges = 
            ISBN_Data::get_publisher_ranges( $english_group_code );
        $this->assertEqual($english_publisher_ranges, $expected_english_publisher_ranges);
    }
}

?>

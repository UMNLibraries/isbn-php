<?php

namespace UmnLib\Core\Tests;

use UmnLib\Core\Isbn\Data;

class IsbnDataTest extends \PHPUnit_Framework_TestCase
{
  function testGroupCodeExists()
  {
    $this->assertTrue(Data::groupCodeExists('0'));
    $this->assertFalse(Data::groupCodeExists('bogus'));
  }

  function testMaxGroupCodeLength()
  {
    // This will fail if the data changes to include longer codes!
    $length = Data::maxGroupCodeLength();
    $this->assertEquals(5, $length);
  }

  function testPublisherRanges()
  {
    $englishGroupCode = '0';

/*
        $expectedEnglishGroupData = array('English speaking area' => array(
            '00' => '19',
            '200' => '699',
            '7000' => '8499',
            '85000' => '89999',
            '900000' => '949999',
            '9500000' => '9999999',
        ));
        $englishGroupData = $isbn->groupData( $englishGroupCode );
        $this->assertEqual($englishGroupData, $expectedEnglishGroupData);
 */
    $expectedEnglishPublisherRanges = array(
      '00' => '19',
      '200' => '699',
      '7000' => '8499',
      '85000' => '89999',
      '900000' => '949999',
      '9500000' => '9999999',
    );

    $englishPublisherRanges = Data::getPublisherRanges($englishGroupCode);
    $this->assertEquals($expectedEnglishPublisherRanges, $englishPublisherRanges);
  }
}

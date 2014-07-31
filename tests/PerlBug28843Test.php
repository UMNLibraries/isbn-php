<?php

namespace UmnLib\Core\Tests;

use UmnLib\Core\Isbn\Factory;

class PerlBug28843Test extends \PHPUnit_Framework_TestCase
{
  /**
   * @expectedException \InvalidArgumentException
   */
  function test_isbn()
  {
    // TODO: Add exception type-checking!
    $invalidPrefixIsbn = '1234567890123';
    $isbn = Factory::create($invalidPrefixIsbn);
  }
}

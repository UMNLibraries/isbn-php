<?php

namespace UmnLib\Core\Tests;

use UmnLib\Core\Isbn\Factory;

class PerlBug27107Test extends \PHPUnit_Framework_TestCase
{
  function testIsbn()
  {
    $isbnString = '9789607771278';
    $isbn = Factory::create($isbnString);
    $this->assertInstanceOf('\UmnLib\Core\Isbn\Isbn13', $isbn);
    $this->assertEquals($isbnString, $isbn->asString(array()));

    $clone = $isbn->asIsbn13();
    $this->assertInstanceOf('\UmnLib\Core\Isbn\Isbn13', $clone);
  }
}

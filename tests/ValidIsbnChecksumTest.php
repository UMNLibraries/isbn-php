<?php

namespace UmnLib\Core\Tests;

use UmnLib\Core\Isbn\Factory;

class ValidIsbnChecksumTest extends \PHPUnit_Framework_TestCase
{
  function testGoodIsbns()
  {
    $isbn10 = Factory::create('0596527241');
    $this->assertInstanceOf('\UmnLib\Core\Isbn\Isbn10', $isbn10);

    $isbn13 = Factory::create('9780596527242');
    $this->assertInstanceOf('\UmnLib\Core\Isbn\Isbn13', $isbn13);
  }

  /**
   * @expectedException \InvalidArgumentException
   */
  function testBadIsbn10()
  {
    $isbn = Factory::create('059652724X');
  }

  /**
   * @expectedException \InvalidArgumentException
   */
  function testBadIsbn13()
  {
    $isbn = Factory::create('9780596527243');
  }
}

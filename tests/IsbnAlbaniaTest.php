<?php

namespace UmnLib\Core\Tests;

use UmnLib\Core\Isbn\Factory;

class IsbnAlbaniaTest extends \PHPUnit_Framework_TestCase
{
  function testIsbn()
  {
    $isbn = Factory::create('9992701579');
    $this->assertInstanceOf('\UmnLib\Core\Isbn\Isbn10', $isbn);

    $this->assertEquals('99927', $isbn->groupCode());
    $this->assertEquals('0', $isbn->publisherCode());
    $this->assertEquals('157', $isbn->articleCode());
    $this->assertEquals('9', $isbn->checksum());
    $this->assertEquals('99927-0-157-9', $isbn->asString());
  }
}

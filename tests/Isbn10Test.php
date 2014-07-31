<?php

namespace UmnLib\Core\Tests;

use UmnLib\Core\Isbn\Factory;

class Isbn10Test extends \PHPUnit_Framework_TestCase
{
  function __construct()
  {
    $this->goodIsbn10 = '0596527241'; 
    $this->goodIsbn10String = '0-596-52724-1'; 
    $this->prefix = '';
    $this->groupCode = '0';
    $this->publisherCode = '596';
    $this->articleCode = '52724';
    $this->checksum = '1';

    //my $GOOD_EAN           = "9780596527242";
    $this->goodIsbn13 = '9780596527242';

    //my $GOOD_EAN_STRING    = "978-0-596-52724-2";
    $this->goodIsbn13String = '978-0-596-52724-2';

    $this->goodIsbn13Prefix = '978';
    $this->goodIsbn13Checksum = '2';

    $this->badChecksumIsbn = '0596527244';

    $this->badGroupIsbn = '9997022576';

    // 91-650-22222-?  Sweden (stops at 649)
    $this->badPublisherIsbn = '9165022222';
  }

  function testGoodIsbn10()
  {
    $isbn = Factory::create(
      $this->goodIsbn10
    );
    $this->assertInstanceOf('\UmnLib\Core\Isbn\Isbn10', $isbn);
    $this->isbn = $isbn;

    //is( $isbn->prefix,         '',                "$GOOD_ISBN has right prefix");
    $this->assertEquals($this->prefix, $isbn->prefix(), 'good ISBN has right prefix');

    //is( $isbn->publisher_code, $PUBLISHER,        "$GOOD_ISBN has right publisher");
    $this->assertEquals($this->publisherCode, $isbn->publisherCode(), 'good ISBN has right publisher');

    //is( $isbn->group_code,     $GROUP_CODE,       "$GOOD_ISBN has right country code");
    $this->assertEquals($this->groupCode, $isbn->groupCode(), 'good ISBN has right country code');

    //like( $isbn->group,        qr/\Q$GROUP/,      "$GOOD_ISBN has right country");
    // Skipping... not sure why I would need this.

    //is( $isbn->article_code,   $ARTICLE,          "$GOOD_ISBN has right article");
    $this->assertEquals($this->articleCode, $isbn->articleCode(), 'good ISBN has right article');

    //is( $isbn->checksum,       $CHECKSUM,         "$GOOD_ISBN has right checksum");
    $this->assertEquals($this->checksum, $isbn->checksum(), 'good ISBN has right checksum');

    //is( $isbn->as_string,      $GOOD_ISBN_STRING, "$GOOD_ISBN stringifies correctly");
    $this->assertEquals( $this->goodIsbn10String, $isbn->asString(), 'good ISBN stringifies correctly');

    //is( $isbn->as_string([]),  $GOOD_ISBN,        "$GOOD_ISBN stringifies correctly");
    $this->assertEquals($this->goodIsbn10, $isbn->asString(array()), 'good ISBN stringifies correctly');

    //is( $isbn->as_string([]),  $isbn->common_data, "$GOOD_ISBN stringifies correctly");
    // I skipped this test, since it seemed identical to the previous one.

    return $isbn;
  }

  function testGoodIsbn10String()
  {
    $isbn10String = Factory::create(
      $this->goodIsbn10String
    );
    $this->assertInstanceOf('\UmnLib\Core\Isbn\Isbn10', $isbn10String);
    //$this->isbn = $isbn;

    //is( $isbn->prefix,         '',                "$GOOD_ISBN has right prefix");
    $this->assertEquals('', $isbn10String->prefix(), 'good ISBN has right prefix');

    //is( $isbn->publisher_code, $PUBLISHER,        "$GOOD_ISBN has right publisher");
    $this->assertEquals($this->publisherCode, $isbn10String->publisherCode(), 'good ISBN has right publisher');

    //is( $isbn->group_code,     $GROUP_CODE,       "$GOOD_ISBN has right country code");
    $this->assertEquals($this->groupCode, $isbn10String->groupCode(), 'good ISBN has right country code');

    //like( $isbn->group,        qr/\Q$GROUP/,      "$GOOD_ISBN has right country");
    // Skipping... not sure why I would need this.

    //is( $isbn->article_code,   $ARTICLE,          "$GOOD_ISBN has right article");
    $this->assertEquals($this->articleCode, $isbn10String->articleCode(), 'good ISBN has right article');

    //is( $isbn->checksum,       $CHECKSUM,         "$GOOD_ISBN has right checksum");
    $this->assertEquals($this->checksum, $isbn10String->checksum(), 'good ISBN has right checksum');

    //is( $isbn->as_string,      $GOOD_ISBN_STRING, "$GOOD_ISBN stringifies correctly");
    $this->assertEquals($this->goodIsbn10String, $isbn10String->asString(), 'good ISBN stringifies correctly');

    //is( $isbn->as_string([]),  $GOOD_ISBN,        "$GOOD_ISBN stringifies correctly");
    $this->assertEquals($this->goodIsbn10, $isbn10String->asString(array()), 'good ISBN stringifies correctly');

    //is( $isbn->as_string([]),  $isbn->common_data, "$GOOD_ISBN stringifies correctly");
    // I skipped this test, since it seemed identical to the previous one.
  }

  /**
   * @depends testGoodIsbn10
   */
  function testGoodIsbn10Clone($isbn)
  {
    //$isbn = $this->isbn;
    $clone = $isbn->asIsbn10();
    $this->assertInstanceOf('\UmnLib\Core\Isbn\Isbn10', $clone);

    //is( $clone->publisher_code, $PUBLISHER,        "$GOOD_ISBN has right publisher");
    $this->assertEquals($this->publisherCode, $clone->publisherCode(), 'good ISBN has right publisher');

    //is( $clone->group_code,     $GROUP_CODE,       "$GOOD_ISBN has right country code");
    $this->assertEquals($this->groupCode, $clone->groupCode(), 'good ISBN has right country code');

    //like( $clone->group,        qr/\Q$GROUP/,      "$GOOD_ISBN has right country");
    // Skipping... not sure why I would need this.

    //is( $isbn->article_code,   $ARTICLE,          "$GOOD_ISBN has right article");
    $this->assertEquals($this->articleCode, $clone->articleCode(), 'good ISBN has right article');

    //is( $isbn->checksum,       $CHECKSUM,         "$GOOD_ISBN has right checksum");
    $this->assertEquals($this->checksum, $clone->checksum(), 'good ISBN has right checksum');

    //is( $clone->as_string,      $GOOD_ISBN_STRING, "$GOOD_ISBN stringifies correctly");
    $this->assertEquals($this->goodIsbn10String, $clone->asString(), 'good ISBN stringifies correctly');

    //is( $clone->as_string([]),  $GOOD_ISBN,        "$GOOD_ISBN stringifies correctly");
    $this->assertEquals($this->goodIsbn10, $clone->asString(array()), 'good ISBN stringifies correctly');
  }

  /**
   * @depends testGoodIsbn10
   */
  function testIsbn13Conversion($isbn)
  {
    //$isbn = $this->isbn;
    $isbn13 = $isbn->asIsbn13();
    $this->assertInstanceOf('\UmnLib\Core\Isbn\Isbn13', $isbn13);

    //is( $clone->publisher_code, $PUBLISHER,        "$GOOD_ISBN has right publisher");
    $this->assertEquals($this->publisherCode, $isbn13->publisherCode(), 'good ISBN has right publisher');

    //is( $clone->group_code,     $GROUP_CODE,       "$GOOD_ISBN has right country code");
    $this->assertEquals($this->groupCode, $isbn13->groupCode(), 'good ISBN has right country code');

    //like( $clone->group,        qr/\Q$GROUP/,      "$GOOD_ISBN has right country");
    // Skipping... not sure why I would need this.

    //is( $isbn->article_code,   $ARTICLE,          "$GOOD_ISBN has right article");
    $this->assertEquals($this->articleCode, $isbn13->articleCode(), 'good ISBN has right article');

    $this->assertEquals($this->goodIsbn13Prefix, $isbn13->prefix(), 'good ISBN-13 has right prefix');

    //is( $isbn->checksum,       $CHECKSUM,         "$GOOD_ISBN has right checksum");
    $this->assertEquals($this->goodIsbn13Checksum, $isbn13->checksum(), 'good ISBN has right checksum');

    //is( $clone->as_string,      $GOOD_ISBN_STRING, "$GOOD_ISBN stringifies correctly");
    $this->assertEquals($this->goodIsbn13String, $isbn13->asString(), 'good ISBN stringifies correctly');

    //is( $clone->as_string([]),  $GOOD_ISBN,        "$GOOD_ISBN stringifies correctly");
    $this->assertEquals($this->goodIsbn13, $isbn13->asString(array()), 'good ISBN stringifies correctly');
  }

  /**
   * @expectedException \InvalidArgumentException
   */
  function testBadChecksum()
  {
    $isbn = Factory::create($this->badChecksumIsbn);
/*
        isa_ok( $isbn, 'Business::ISBN10' );
        is( $isbn->error, BAD_CHECKSUM, 
          "Bad checksum [$BAD_CHECKSUM_ISBN] is invalid" );
        is( $isbn->input_isbn, $BAD_CHECKSUM_ISBN, "Bad ISBN is in input_data" );

        #after this we should have a good ISBN
        $isbn->fix_checksum;
        ok( $isbn->is_valid, 
          "Bad checksum [$BAD_CHECKSUM_ISBN] had checksum fixed" );
        is( $isbn->input_isbn, $BAD_CHECKSUM_ISBN, "Bad ISBN is still in input_data" );
 */
  }

  /**
   * @expectedException \InvalidArgumentException
   */
  function testBadGroupCode()
  {
    // bad country code?
    $isbn = Factory::create($this->badGroupIsbn);
/*
        isa_ok( $isbn, 'Business::ISBN10' );
        is( $isbn->error, INVALID_GROUP_CODE, 
          "Bad group code [$BAD_GROUP_ISBN] is invalid" );
 */
  }

  /**
   * @expectedException \InvalidArgumentException
   */
  function testBadPublisherCode()
  {
    // bad publisher code?
    $isbn = Factory::create($this->badPublisherIsbn);

/*
        isa_ok( $isbn, 'Business::ISBN10' );
        is( $isbn->error, INVALID_PUBLISHER_CODE, 
          "Bad publisher [$BAD_PUBLISHER_ISBN] is invalid" );
 */
  }

        /* Skipping this, since I plan on making ISBNs immutable.
        # Am I prevented from doing bad things?
        my $result = eval { $isbn->_set_prefix( '978' ) };
        ok( defined $@, "Setting prefix on ISBN-10 fails" );
         */

  function testManyGoodIsbns()
  {
    $fh = fopen(dirname(__FILE__) . '/fixtures/isbns.txt', 'r');
    while (!feof($fh)) {
      $goodIsbn = trim(fgets($fh));
      if ($goodIsbn == '') continue;
      $isbn = Factory::create( $goodIsbn ); 
      $this->assertInstanceOf('\UmnLib\Core\Isbn\Isbn10', $isbn);
    }
    fclose($fh);
  }

  function testManyBadIsbns()
  {
    $fh = fopen(dirname(__FILE__) . '/fixtures/bad-isbns.txt', 'r');
    while (!feof($fh)) {
      // NOTE: We must test for $e being set in this klugey
      // way, because expetException can be called only once.
      // After that, no more tests get run.
      unset( $e );
      $badIsbn = trim(fgets($fh));
      try {
        $isbn = Factory::create($badIsbn); 
      } catch (\Exception $e) { }
        $this->assertTrue(isset($e));
    }
    fclose($fh);
  }

/*
# $Revision: 2.6 $
use strict;

use Test::More 'no_plan';

use Business::ISBN qw(:all);

# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
my $GOOD_ISBN          = "0596527241";
my $GOOD_ISBN_STRING   = "0-596-52724-1";

my $GOOD_EAN           = "9780596527242";
my $GOOD_EAN_STRING    = "978-0-596-52724-2";

my $GROUP              = "English";

my $PREFIX             = '978';

my $GROUP_CODE         = "0";
my $PUBLISHER          = "596";

my $BAD_CHECKSUM_ISBN  = "0596527244";

my $BAD_GROUP_ISBN     = "9997022576";

my $BAD_PUBLISHER_ISBN = "9165022222"; # 91-650-22222-?  Sweden (stops at 649)

my $NULL_ISBN          = undef;

my $NO_GOOD_CHAR_ISBN  = "abcdefghij";

my $SHORT_ISBN         = "156592";


# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# test to see if we can construct an object?
my $isbn = Business::ISBN->new( $GOOD_ISBN );
isa_ok( $isbn, 'Business::ISBN10' );
is( $isbn->is_valid,       GOOD_ISBN, "$GOOD_ISBN is valid" );

is( $isbn->type,           'ISBN10',          "$GOOD_ISBN has right type");

is( $isbn->prefix,         '',                "$GOOD_ISBN has right prefix");
is( $isbn->publisher_code, $PUBLISHER,        "$GOOD_ISBN has right publisher");
is( $isbn->group_code,     $GROUP_CODE,       "$GOOD_ISBN has right country code");
like( $isbn->group,        qr/\Q$GROUP/,      "$GOOD_ISBN has right country");
is( $isbn->as_string,      $GOOD_ISBN_STRING, "$GOOD_ISBN stringifies correctly");
is( $isbn->as_string([]),  $GOOD_ISBN,        "$GOOD_ISBN stringifies correctly");

is( $isbn->as_string([]),  $isbn->common_data, "$GOOD_ISBN stringifies correctly");

# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# can I clone it?
{
my $clone = $isbn->as_isbn10;

isa_ok( $clone, 'Business::ISBN10' );
is( $clone->is_valid,       GOOD_ISBN, "$GOOD_ISBN is valid" );

is( $clone->publisher_code, $PUBLISHER,        "$GOOD_ISBN has right publisher");
is( $clone->group_code,     $GROUP_CODE,       "$GOOD_ISBN has right country code");
like( $clone->group,        qr/\Q$GROUP/,      "$GOOD_ISBN has right country");
is( $clone->as_string,      $GOOD_ISBN_STRING, "$GOOD_ISBN stringifies correctly");
is( $clone->as_string([]),  $GOOD_ISBN,        "$GOOD_ISBN stringifies correctly");
}

# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# can I make it ISBN13?
{
my $clone = $isbn->as_isbn13;

isa_ok( $clone, 'Business::ISBN13' );
is( $clone->is_valid,       GOOD_ISBN, "$GOOD_ISBN is valid" );

is( $clone->type,           'ISBN13',          "$GOOD_ISBN has right type");
is( $clone->prefix,         $PREFIX,           "$GOOD_ISBN has right prefix");
is( $clone->publisher_code, $PUBLISHER,        "$GOOD_ISBN has right publisher");
is( $clone->group_code,     $GROUP_CODE,       "$GOOD_ISBN has right country code");
like( $clone->group,        qr/\Q$GROUP/,      "$GOOD_ISBN has right country");
is( $clone->as_string,      $GOOD_EAN_STRING,  "$GOOD_ISBN stringifies correctly");
is( $clone->as_string([]),  $GOOD_EAN,         "$GOOD_ISBN stringifies correctly");
}

# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# and bad checksums?
$isbn = Business::ISBN->new( $BAD_CHECKSUM_ISBN );
isa_ok( $isbn, 'Business::ISBN10' );
is( $isbn->error, BAD_CHECKSUM, 
  "Bad checksum [$BAD_CHECKSUM_ISBN] is invalid" );
is( $isbn->input_isbn, $BAD_CHECKSUM_ISBN, "Bad ISBN is in input_data" );

#after this we should have a good ISBN
$isbn->fix_checksum;
ok( $isbn->is_valid, 
  "Bad checksum [$BAD_CHECKSUM_ISBN] had checksum fixed" );
is( $isbn->input_isbn, $BAD_CHECKSUM_ISBN, "Bad ISBN is still in input_data" );

# bad country code?
$isbn = Business::ISBN->new( $BAD_GROUP_ISBN );
isa_ok( $isbn, 'Business::ISBN10' );
is( $isbn->error, INVALID_GROUP_CODE, 
  "Bad group code [$BAD_GROUP_ISBN] is invalid" );

# bad publisher code?
$isbn = Business::ISBN->new( $BAD_PUBLISHER_ISBN );
isa_ok( $isbn, 'Business::ISBN10' );
is( $isbn->error, INVALID_PUBLISHER_CODE, 
  "Bad publisher [$BAD_PUBLISHER_ISBN] is invalid" );

# convert to EAN?
$isbn = Business::ISBN->new( $GOOD_ISBN );
is( $isbn->as_isbn13->as_string([]), $GOOD_EAN, "$GOOD_ISBN converted to EAN" );

# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Am I prevented from doing bad things?

my $result = eval { $isbn->_set_prefix( '978' ) };
ok( defined $@, "Setting prefix on ISBN-10 fails" );


# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# parse a bunch of good ones
SKIP:
  {
  my $file = "isbns.txt";

  open FILE, $file or 
    skip( "Could not read $file: $!", 1, "Need $file");

  diag "\nChecking ISBNs... (this may take a bit)";

  my $bad = 0;
  while( <FILE> )
    {
    chomp;
    my $isbn = Business::ISBN->new( $_ );

    my $result = $isbn->is_valid;
    my $text   = $Business::ISBN::ERROR_TEXT{ $result };

    $bad++ unless $result eq Business::ISBN::GOOD_ISBN;
    diag "\n\t$_ is not valid? [ $result -> $text ]" 
      unless $result eq Business::ISBN::GOOD_ISBN;	
    }

  close FILE;

  ok( $bad == 0, "Match good ISBNs" );
  }

# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# fail on a bunch of bad ones
SKIP:
  {
  my $file = "bad-isbns.txt";

  open FILE, $file or 
    skip( "Could not read $file: $!", 1, "Need $file");

  diag "\nChecking bad ISBNs... (this should be fast)";

  my $good = 0;
  my @good = ();

  while( <FILE> )
    {
    chomp;
    my $valid = eval { Business::ISBN->new( $_ )->is_valid };
    next unless $valid;

    push @good, $_;

    $good++;	
    }

  close FILE;

  {
  local $" = "\n\t";
  ok( $good == 0, "Don't match bad ISBNs" ) || 
    diag( "\nMatched $good bad ISBNs\n\t@good" );
  }

  }
 */

}

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
        $this->good_isbn10 = '0596527241'; 
        $this->good_isbn10_string = '0-596-52724-1'; 
        $this->prefix = '';
        $this->group_code = '0';
        $this->publisher_code = '596';
        $this->article_code = '52724';
        $this->checksum = '1';

        //my $GOOD_EAN           = "9780596527242";
        $this->good_isbn13 = '9780596527242';

        //my $GOOD_EAN_STRING    = "978-0-596-52724-2";
        $this->good_isbn13_string = '978-0-596-52724-2';

        $this->good_isbn13_prefix = '978';
        $this->good_isbn13_checksum = '2';

        $this->bad_checksum_isbn = '0596527244';
        
        $this->bad_group_isbn = '9997022576';

        // 91-650-22222-?  Sweden (stops at 649)
        $this->bad_publisher_isbn = '9165022222';
    }

    function test_good_isbn10()
    {
        $isbn = ISBN_Factory::create(
            $this->good_isbn10
        );
        $this->assertIsA($isbn, 'ISBN10');
        $this->isbn = $isbn;
        /*
        print_r( $isbn );
        echo "\n";
        */

        //is( $isbn->prefix,         '',                "$GOOD_ISBN has right prefix");
        $this->assertEqual( $isbn->prefix(), $this->prefix );

        //is( $isbn->publisher_code, $PUBLISHER,        "$GOOD_ISBN has right publisher");
        $this->assertEqual( $isbn->publisher_code(), $this->publisher_code );

        //is( $isbn->group_code,     $GROUP_CODE,       "$GOOD_ISBN has right country code");
        $this->assertEqual( $isbn->group_code(), $this->group_code );

        //like( $isbn->group,        qr/\Q$GROUP/,      "$GOOD_ISBN has right country");
        // Skipping... not sure why I would need this.
        
        //is( $isbn->article_code,   $ARTICLE,          "$GOOD_ISBN has right article");
        $this->assertEqual( $isbn->article_code(), $this->article_code );
        
        //is( $isbn->checksum,       $CHECKSUM,         "$GOOD_ISBN has right checksum");
        $this->assertEqual( $isbn->checksum(), $this->checksum );

        //is( $isbn->as_string,      $GOOD_ISBN_STRING, "$GOOD_ISBN stringifies correctly");
        $this->assertEqual( $isbn->as_string(), $this->good_isbn10_string );

        //is( $isbn->as_string([]),  $GOOD_ISBN,        "$GOOD_ISBN stringifies correctly");
        $this->assertEqual( $isbn->as_string(array()), $this->good_isbn10 );
        
        //is( $isbn->as_string([]),  $isbn->common_data, "$GOOD_ISBN stringifies correctly");
        // I skipped this test, since it seemed identical to the previous one.
    }

    function test_good_isbn10_string()
    {
        $isbn10_string = ISBN_Factory::create(
            $this->good_isbn10_string
        );
        $this->assertIsA($isbn10_string, 'ISBN10');
        //$this->isbn = $isbn;
        
        //print_r( $isbn );
        //echo "\n";

        //is( $isbn->prefix,         '',                "$GOOD_ISBN has right prefix");
        $this->assertEqual( $isbn10_string->prefix(), '' );

        //is( $isbn->publisher_code, $PUBLISHER,        "$GOOD_ISBN has right publisher");
        $this->assertEqual( $isbn10_string->publisher_code(), $this->publisher_code );

        //is( $isbn->group_code,     $GROUP_CODE,       "$GOOD_ISBN has right country code");
        $this->assertEqual( $isbn10_string->group_code(), $this->group_code );

        //like( $isbn->group,        qr/\Q$GROUP/,      "$GOOD_ISBN has right country");
        // Skipping... not sure why I would need this.
        
        //is( $isbn->article_code,   $ARTICLE,          "$GOOD_ISBN has right article");
        $this->assertEqual( $isbn10_string->article_code(), $this->article_code );
        
        //is( $isbn->checksum,       $CHECKSUM,         "$GOOD_ISBN has right checksum");
        $this->assertEqual( $isbn10_string->checksum(), $this->checksum );

        //is( $isbn->as_string,      $GOOD_ISBN_STRING, "$GOOD_ISBN stringifies correctly");
        $this->assertEqual( $isbn10_string->as_string(), $this->good_isbn10_string );

        //is( $isbn->as_string([]),  $GOOD_ISBN,        "$GOOD_ISBN stringifies correctly");
        $this->assertEqual( $isbn10_string->as_string(array()), $this->good_isbn10 );
        
        //is( $isbn->as_string([]),  $isbn->common_data, "$GOOD_ISBN stringifies correctly");
        // I skipped this test, since it seemed identical to the previous one.
    }

    function test_good_isbn10_clone()
    {
        $isbn = $this->isbn;
        $clone = $isbn->as_isbn10();
        $this->assertIsA($clone, 'ISBN10');

        //is( $clone->publisher_code, $PUBLISHER,        "$GOOD_ISBN has right publisher");
        $this->assertEqual( $clone->publisher_code(), $this->publisher_code );

        //is( $clone->group_code,     $GROUP_CODE,       "$GOOD_ISBN has right country code");
        $this->assertEqual( $clone->group_code(), $this->group_code );

        //like( $clone->group,        qr/\Q$GROUP/,      "$GOOD_ISBN has right country");
        // Skipping... not sure why I would need this.

        //is( $isbn->article_code,   $ARTICLE,          "$GOOD_ISBN has right article");
        $this->assertEqual( $clone->article_code(), $this->article_code );

        //is( $isbn->checksum,       $CHECKSUM,         "$GOOD_ISBN has right checksum");
        $this->assertEqual( $clone->checksum(), $this->checksum );

        //is( $clone->as_string,      $GOOD_ISBN_STRING, "$GOOD_ISBN stringifies correctly");
        $this->assertEqual( $clone->as_string(), $this->good_isbn10_string );

        //is( $clone->as_string([]),  $GOOD_ISBN,        "$GOOD_ISBN stringifies correctly");
        $this->assertEqual( $clone->as_string(array()), $this->good_isbn10 );
        
    }

    function test_isbn13_conversion()
    {
        $isbn = $this->isbn;
        $isbn13 = $isbn->as_isbn13();
        $this->assertIsA($isbn13, 'ISBN13');
 
        //is( $clone->publisher_code, $PUBLISHER,        "$GOOD_ISBN has right publisher");
        $this->assertEqual( $isbn13->publisher_code(), $this->publisher_code );

        //is( $clone->group_code,     $GROUP_CODE,       "$GOOD_ISBN has right country code");
        $this->assertEqual( $isbn13->group_code(), $this->group_code );

        //like( $clone->group,        qr/\Q$GROUP/,      "$GOOD_ISBN has right country");
        // Skipping... not sure why I would need this.

        //is( $isbn->article_code,   $ARTICLE,          "$GOOD_ISBN has right article");
        $this->assertEqual( $isbn13->article_code(), $this->article_code );

        $this->assertEqual( $isbn13->prefix(), $this->good_isbn13_prefix );

        //is( $isbn->checksum,       $CHECKSUM,         "$GOOD_ISBN has right checksum");
        $this->assertEqual( $isbn13->checksum(), $this->good_isbn13_checksum );

        //is( $clone->as_string,      $GOOD_ISBN_STRING, "$GOOD_ISBN stringifies correctly");
        $this->assertEqual( $isbn13->as_string(), $this->good_isbn13_string );

        //is( $clone->as_string([]),  $GOOD_ISBN,        "$GOOD_ISBN stringifies correctly");
        $this->assertEqual( $isbn13->as_string(array()), $this->good_isbn13 );
    }

    function test_bad_checksum()
    {
        $this->expectException();
        $isbn = ISBN_Factory::create( $this->bad_checksum_isbn );
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

    function test_bad_group_code()
    {
        // bad country code?
        $this->expectException();
        $isbn = ISBN_Factory::create( $this->bad_group_isbn );
/*
        isa_ok( $isbn, 'Business::ISBN10' );
        is( $isbn->error, INVALID_GROUP_CODE, 
        	"Bad group code [$BAD_GROUP_ISBN] is invalid" );
*/
    }

    function test_bad_publisher_code()
    {
        // bad publisher code?
        $this->expectException();
        $isbn = ISBN_Factory::create( $this->bad_publisher_isbn );

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

    function test_many_good_isbns()
    {
        $fh = fopen(getcwd() . '/isbns.txt', 'r');
        while (!feof($fh)) {
            $good_isbn = trim(fgets($fh));
            if ($good_isbn == '') continue;
            $isbn = ISBN_Factory::create( $good_isbn ); 
            $this->assertIsA($isbn, 'ISBN10');
        }
        fclose($fh);
    }

    function test_many_bad_isbns()
    {
        $fh = fopen(getcwd() . '/bad-isbns.txt', 'r');
        while (!feof($fh)) {
            // NOTE: We must test for $e being set in this klugey
            // way, because expetException can be called only once.
            // After that, no more tests get run.
            unset( $e );
            $bad_isbn = trim(fgets($fh));
            try {
                $isbn = ISBN_Factory::create( $bad_isbn ); 
            } catch (Exception $e) { }
            $this->assertTrue( isset($e) );
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

?>

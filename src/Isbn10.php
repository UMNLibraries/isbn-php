<?php

namespace UmnLib\Core\Isbn;

class Isbn10 extends Isbn
{

/*
//use strict;
//use Business::ISBN qw(:all);

use subs qw( 
	_checksum
	INVALID_GROUP_CODE
	INVALID_PUBLISHER_CODE
	BAD_CHECKSUM
	GOOD_ISBN
	BAD_ISBN
	);

use vars qw( 
	$VERSION 
	$debug 
	$MAX_GROUP_CODE_LENGTH 
	%ERROR_TEXT 
	);

//use Carp qw(carp croak cluck);

//my $debug = 0;

//$VERSION   = '2.05';
*/

//sub _max_length { 10 }
    public static function maxLength()
    {
        return 10;
    }

    // This is clunky; shouldn't need a type at all, especially since
    // we support only OO for PHP.
    //sub _set_type     { $_[0]->{type} = 'ISBN10' }

    //sub _parse_prefix { '' }
    // TODO: Don't think we need a prefix...
    public static function parsePrefix($isbn)
    {
      return '';
    }

/*
sub _set_prefix   
  { 
  croak "Cannot set prefix [$_[1]] on an ISBN-10" if length $_[1];

  $_[0]->{prefix} = $_[1];
  }
 */
    // TODO: Should this class even have a prefix? Seems clunky.
    public function setPrefix($prefix)
    {
      if (strlen($prefix)) {
        throw new \InvalidArgumentException("Prefix '$prefix' is invalid.");
      }
    }

    public function prefix()
    {
      return '';
    }

/*
sub _hyphen_positions { 
  [
  $_[0]->_group_code_length,
  $_[0]->_group_code_length + $_[0]->_publisher_code_length,
  9
  ]
  }	
 */	
    // Important: these positions will be used in reverse order!!!
    // TODO: Are they really used in reverse for ISBN10???
    public function hyphenPositions()
    {
      $groupCodeLength = strlen($this->groupCode());
      return array(
        $groupCodeLength,
        $groupCodeLength + strlen($this->publisherCode()),
        9,
      );
    }

/*
sub as_isbn10
  {
  my $self = shift;

  my $isbn10 = Business::ISBN->new( $self->isbn );
  $isbn10->fix_checksum;

  return $isbn10;
  }
 */
    public function asIsbn10()
    {
      $isbn10 = new Isbn10(array(
        'isbn' => $this->isbn(),
      ));
      return $isbn10;
    }

/*
sub as_isbn13
  {
  my $self = shift;

  my $isbn13 = Business::ISBN->new( '978' . $self->isbn );
  $isbn13->fix_checksum;

  return $isbn13;
  }
 */
    public function asIsbn13()
    {
      $isbn13MinusChecksum =
        '978' .
        $this->groupCode() .
        $this->publisherCode() .
        $this->articleCode();
      $isbn13Checksum = 
        Isbn13::calculateChecksum( $isbn13MinusChecksum );
      $paramIsbn = $isbn13MinusChecksum . $isbn13Checksum;

      $isbn13 = new Isbn13(array(
        'isbn' => $paramIsbn,
      ));
      return $isbn13;
    }

/*
#internal function.  you don't get to use this one.
sub _checksum
  {
  my $data = $_[0]->isbn;

  return unless defined $data;

  my @digits = split //, $data;
  my $sum    = 0;

  foreach( reverse 2..10 )
    {
    $sum += $_ * (shift @digits);
    }

  #return what the check digit should be
  my $checksum = (11 - ($sum % 11))%11;

  $checksum = 'X' if $checksum == 10;

  return $checksum;
  }
 */
    // I found "_checksum" non-descriptive, so I call it "calculateChecksum".
    public static function calculateChecksum($isbnMinusChecksum)
    {
      if (strlen($isbnMinusChecksum) != self::maxLength() -1) {
        throw new \InvalidArgumentException("Invalid length for argument isbnMinusChecksum '$isbnMinusChecksum'.");
      }

      //$digits = str_split( $this->isbn() );
      $digits = str_split($isbnMinusChecksum);
      $sum = 0;
      foreach (range(10, 2) as $number) {
        $sum += $number * array_shift($digits);
      }
      $checksum = (11 - ($sum % 11)) % 11;
      if ($checksum == 10) $checksum = 'X';
      return $checksum;
    }

}

/*
__END__

=head1 NAME

Business::ISBN10 - work with 10 digit International Standard Book Numbers

=head1 SYNOPSIS

See L<Business::ISBN>

=head1 DESCRIPTION

See L<Business::ISBN>

=head1 SOURCE AVAILABILITY

This source is in Github:

    http://github.com/briandfoy/business--isbn/tree/master

=head1 AUTHOR

brian d foy C<< <bdfoy@cpan.org> >>

=head1 COPYRIGHT AND LICENSE

Copyright (c) 2001-2009, brian d foy, All Rights Reserved.

You may redistribute this under the same terms as Perl itself.

=cut
 */

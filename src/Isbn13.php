<?php

namespace UmnLib\Core\Isbn;

class Isbn13 extends Isbn
{

/*
# $Revision: 2.8 $
# $Id: ISBN13.pm,v 2.8 2007/09/17 02:34:58 comdog Exp $
package Business::ISBN13;
use strict;
use base qw(Business::ISBN);

use Business::ISBN qw(:all);
use Data::Dumper;

use subs qw( 
  _checksum
  INVALID_COUNTRY_CODE
  INVALID_PUBLISHER_CODE
  BAD_CHECKSUM
  GOOD_ISBN
  BAD_ISBN
  );
use vars qw( 
  $VERSION 
  $debug
  );

use Carp qw(carp croak cluck);

my $debug = 0;

$VERSION   = '2.05';
 */

  //sub _max_length { 13 }
  public static function maxLength()
  {
    return 13;
  }

  // This is clunky; shouldn't need a type at all, especially since
  // we support only OO for PHP.
  //sub _set_type     { $_[0]->{type} = 'ISBN13' }

/*
sub _parse_prefix 
  { 
  my $isbn = $_[0]->isbn; # stupid workaround for 'Can't modify non-lvalue subroutine call'
  ( $isbn =~ /\A(97[89])(.{10})\z/g )[0];
  }
 */
  public static function parsePrefix($isbn)
  {
    preg_match('/^(97[89])(.{10})$/', $isbn, $matches);
    if (!isset($matches[1])) {
      throw new \InvalidArgumentException("ISBN13 '$isbn' has an invalid prefix.");
    }
    return $matches[1];
  }

/*
sub _set_prefix   
  { 
  croak "Cannot set prefix [$_[1]] on an ISBN-13"
    unless $_[1] =~ m/\A97[89]\z/;

  $_[0]->{prefix} = $_[1];
  }
 */

  public function setPrefix($prefix)
  {
    if (preg_match('/^97[89]$/', $prefix)) {
      $this->prefix = $prefix;
      return $this;
    }
    throw new \InvalidArgumentException("Prefix '$prefix' is invalid.");
  }

/*
sub _hyphen_positions 
  { 
  [
  $_[0]->_prefix_length,
  $_[0]->_prefix_length + $_[0]->_group_code_length,
  $_[0]->_prefix_length + $_[0]->_group_code_length + $_[0]->_publisher_code_length,
  $_[0]->_checksum_pos,
  ]
  }
 */
  // Important: these positions will be used in reverse order!!!
  public function hyphenPositions()
  {
    $prefixLength = strlen($this->prefix());
    $groupCodeLength = strlen($this->groupCode());
    return array(
      $prefixLength,
      $prefixLength + $groupCodeLength,
      $prefixLength + $groupCodeLength + strlen($this->publisherCode()),
      $this->checksumPos(),
    );
  }

/*
# sub group { 'Bookland' }

sub as_isbn10
  {
  my $self = shift;

  return unless $self->prefix eq '978';

  my $isbn10 = Business::ISBN->new( 
    substr( $self->isbn, 3 )
    );
  $isbn10->fix_checksum;

  return $isbn10;
  }
 */

  public function asIsbn10()
  {
    $isbn10MinusChecksum = 
      $this->groupCode() . 
      $this->publisherCode() .
      $this->articleCode();
    $isbn10Checksum = 
      Isbn10::calculateChecksum($isbn10MinusChecksum);
    $paramIsbn = $isbn10MinusChecksum . $isbn10Checksum;

    $isbn10 = new Isbn10(array(
      'isbn' => $paramIsbn,
    ));
    return $isbn10;
  }

/*
sub as_isbn13
  {
  my $self = shift;

  my $isbn13 = Business::ISBN->new( $self->as_string );
  $isbn13->fix_checksum;

  return $isbn13;
  }
 */
  public function asIsbn13()
  {
    $isbn13 = new Isbn13(array(
      'isbn' => $this->isbn(),
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

  foreach my $index ( 0, 2, 4, 6, 8, 10 )
    {
    $sum +=     substr($data, $index, 1);
    $sum += 3 * substr($data, $index + 1, 1);
    }

  #take the next higher multiple of 10 and subtract the sum.
  #if $sum is 37, the next highest multiple of ten is 40. the
  #check digit would be 40 - 37 => 3.
  my $checksum = ( 10 * ( int( $sum / 10 ) + 1 ) - $sum ) % 10;

  return $checksum;
  }
 */

  // I found "_checksum" non-descriptive, so I call it "calculateChecksum".
  public static function calculateChecksum( $isbnMinusChecksum )
  {
    if (strlen($isbnMinusChecksum) != self::maxLength() -1) {
      throw new \InvalidArgumentException("Invalid length for argument isbnMinusChecksum '$isbnMinusChecksum'.");
    }

    $sum = 0;
    foreach (array(0,2,4,6,8,10) as $index) {
      //$sum += substr($isbn, $index, 1);
      //$sum += 3 * substr($isbn, $index + 1, 1);
      $sum += substr($isbnMinusChecksum, $index, 1);
      $sum += 3 * substr($isbnMinusChecksum, $index + 1, 1);
    }
    // Take the next higher multiple of 10 and subtract the sum.
    // If $sum is 37, the next highest multiple of ten is 40. The
    // check digit would be 40 - 37 => 3.
    $checksum = (10 * ((int)($sum/10) + 1) - $sum) % 10;
    return $checksum;
  }
}

/*
1;

__END__

=head1 NAME

Business::ISBN13 - work with 13 digit International Standard Book Numbers

=head1 SYNOPSIS

See L<Business::ISBN>

=head1 DESCRIPTION

See L<Business::ISBN>

=head1 SOURCE AVAILABILITY

This source is in Github.

  http://github.com/briandfoy/business--isbn/tree/master

=head1 AUTHOR

brian d foy C<< <bdfoy@cpan.org> >>

=head1 COPYRIGHT AND LICENSE

Copyright (c) 2001-2009, brian d foy, All Rights Reserved.

You may redistribute this under the same terms as Perl itself.

=cut
 */

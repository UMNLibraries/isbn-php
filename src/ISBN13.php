<?php

require_once 'ISBN.php';

class ISBN13 extends ISBN
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
    public static function max_length()
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
    public static function parse_prefix( $isbn )
    {
	preg_match('/^(97[89])(.{10})$/', $isbn, $matches);
        if (!isset($matches[1])) {
            throw new Exception("ISBN13 '$isbn' has an invalid prefix.");
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
    
    protected function set_prefix($prefix)
    {
        if (preg_match('/^97[89]$/', $prefix)) {
            $this->prefix = $prefix;
            return $this;
        }
        throw new Exception("Prefix '$prefix' is invalid.");
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
    public function hyphen_positions()
    {
        $prefix_length = strlen($this->prefix());
        $group_code_length = strlen($this->group_code());
        return array(
            $prefix_length,
            $prefix_length + $group_code_length,
            $prefix_length + $group_code_length + strlen($this->publisher_code()),
            $this->checksum_pos(),
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

    public function as_isbn10()
    {
        require_once 'ISBN10.php';

        $isbn10_minus_checksum = 
            $this->group_code() . 
            $this->publisher_code() .
            $this->article_code();
        $isbn10_checksum = 
            ISBN10::calculate_checksum( $isbn10_minus_checksum );
        $param_isbn = $isbn10_minus_checksum . $isbn10_checksum;

        $isbn10 = new ISBN10(array(
            'isbn' => $param_isbn,
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
    public function as_isbn13()
    {
        $isbn13 = new ISBN13(array(
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

    // I found "_checksum" non-descriptive, so I call it "calculate_checksum".
    public static function calculate_checksum( $isbn_minus_checksum )
    {
        if (strlen($isbn_minus_checksum) != self::max_length() -1) {
            throw new Exception("Invalid length for argument isbn_minus_checksum '$isbn_minus_checksum'.");
        }

        $sum = 0;
        foreach (array(0,2,4,6,8,10) as $index) {
            //$sum += substr($isbn, $index, 1);
            //$sum += 3 * substr($isbn, $index + 1, 1);
            $sum += substr($isbn_minus_checksum, $index, 1);
            $sum += 3 * substr($isbn_minus_checksum, $index + 1, 1);
        }
	// Take the next higher multiple of 10 and subtract the sum.
	// If $sum is 37, the next highest multiple of ten is 40. The
	// check digit would be 40 - 37 => 3.
	$checksum = (10 * ((int)($sum/10) + 1) - $sum) % 10;
        return $checksum;
    }

} // end class ISBN13

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

?>

<?php

require_once 'ISBN.php';

class ISBN10 extends ISBN
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
    public static function max_length()
    {
        return 10;
    }

// This is clunky; shouldn't need a type at all, especially since
// we support only OO for PHP.
//sub _set_type     { $_[0]->{type} = 'ISBN10' }

//sub _parse_prefix { '' }
    // TODO: Don't think we need a prefix...
    public static function parse_prefix( $isbn )
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
    protected function set_prefix( $prefix )
    {
        if (strlen($prefix)) {
            throw new Exception("Prefix '$prefix' is invalid.");
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
    public function hyphen_positions()
    {
        $group_code_length = strlen($this->group_code());
        return array(
            $group_code_length,
            $group_code_length + strlen($this->publisher_code()),
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
    public function as_isbn10()
    {
        $isbn10 = new ISBN10(array(
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
    public function as_isbn13()
    {
        require_once 'ISBN13.php';

        $isbn13_minus_checksum =
            '978' .
            $this->group_code() .
            $this->publisher_code() .
            $this->article_code();
        $isbn13_checksum = 
            ISBN13::calculate_checksum( $isbn13_minus_checksum );
        $param_isbn = $isbn13_minus_checksum . $isbn13_checksum;

        $isbn13 = new ISBN13(array(
            'isbn' => $param_isbn,
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
    // I found "_checksum" non-descriptive, so I call it "calculate_checksum".
    public static function calculate_checksum( $isbn_minus_checksum )
    {
        if (strlen($isbn_minus_checksum) != self::max_length() -1) {
            throw new Exception("Invalid length for argument isbn_minus_checksum '$isbn_minus_checksum'.");
        }

        //$digits = str_split( $this->isbn() );
        $digits = str_split( $isbn_minus_checksum );
        $sum = 0;
        foreach (range(10, 2) as $number) {
            $sum += $number * array_shift($digits);
        }
        $checksum = (11 - ($sum % 11)) % 11;
        if ($checksum == 10) $checksum = 'X';
        return $checksum;
    }

} // end class ISBN10

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

<?php

/*
=head1 NAME

Business::ISBN::Data - data pack for Business::ISBN

=head1 SYNOPSIS

see L<Business::ISBN>

=head1 DESCRIPTION

This data is current as of the date in the module version. At that
time, the publisher codes  9990000-9999999 or 999000-999999 had not
been fixed, although they had been proposed. I do not include them in
the data. Some regions, including India (93), Gabon (99902), and Congo
(99951) have country codes but no publisher codes. They still have
entries even though you won't be able to validate any ISBNs assigned
in those regions.

Business::ISBN uses this "data pack" to do its work.  You can update
Business::ISBN::Data independently of the main module as the various
ISBN organizations assign new publisher codes.  The ISBN agency lists
these data at http://www.isbn-international.org/converter/ranges.htm .
It's also available as a javascript file at
http://www.isbn-international.org/converter/ranges.js . The make_data.pl
program creates the meat of this module.

Note, that as a historical artifact, some countries are actually
language areas. For instance, country code 2 is "French", and includes
several French-speaking countries.

Simply install this module over the previous version.  The module is a
Perl data structure, so you can install it with CPAN.pm, or simply
copy it to the right location.

Older versions of this module did not declare a version, and will work
with whatever version of Business::ISBN you have despite anything the
Makefile.PL might say. Some versions tracked the version of
Business::ISBN. Starting in October 2008, the version is the date of
the module update (as YYYYMMDD).

If you make updates, please send them to me so I can include them in
future releases.

=head1 SOURCE AVAILABILITY

This module lives in the Github repository with Business::ISBN:

	git://github.com/briandfoy/business--isbn.git

=head1 AUTHOR

brian d foy, C<< <bdfoy@cpan.org> >>

Yakov Shafranovich updated the data in October 2008.

=head1 COPYRIGHT AND LICENSE

Copyright (c) 2002-2008, brian d foy, All Rights Reserved.

You may redistribute this under the same terms as Perl itself.

=cut

*/

//require_once 'Moose.php';

//class ISBN_Data extends Moose
class ISBN_Data
{

//use strict;
//use vars qw($VERSION);

//$VERSION = '20081208';
//package Business::ISBN;

/*
    protected function properties()
    {
        self::has('country_data', array(
            'is' => 'protected',
            'builder' => 'generate_country_data',
        ));
        self::has('max_country_code_length', array(
            'is' => 'protected',
            'builder' => 'generate_max_country_code_length',
        ));
    }
*/

    // aka "country data"
    protected static $group_data;
    public static function group_data()
    {
        if (!isset(self::$group_data)) {
            self::$group_data = self::generate_group_data();
        }
        return self::$group_data;
    }

    protected static $max_group_code_length;
    public static function max_group_code_length()
    {
        if (!isset(self::$max_group_code_length)) {
            self::$max_group_code_length = self::generate_max_group_code_length();
        }
        return self::$max_group_code_length;
    }

    public static function group_code_exists( $group_code )
    {
        $group_data = self::group_data();
        return array_key_exists($group_code, $group_data) ? true : false;
    }

    public static function get_publisher_ranges( $group_code )
    {
        $group_data = self::group_data();
        $group_code_data = $group_data[ $group_code ];

        // TODO: Isn't there a more elegant way to get the value associated
        // with the first key, even if you don't know what the first key is?
        foreach ($group_code_data as $description => $publisher_ranges) {
            break;
        }
        return $publisher_ranges;
    }

    protected static function generate_group_data()
    {
        return array
        (
         '0'    => array('English speaking area' => array('00' => '19', '200' => '699', '7000' => '8499', '85000' => '89999', '900000' => '949999', '9500000' => '9999999') ),
         '1'    => array('English speaking area' => array('00' => '09', '100' => '399', '4000' => '5499', '55000' => '86979', '869800' => '998999') ),
         '2'    => array('French speaking area' => array('00' => '19', '200' => '349', '35000' => '39999', '400' => '699', '7000' => '8399', '84000' => '89999', '900000' => '949999', '9500000' => '9999999') ),
         '3'    => array('German speaking area' => array('00' => '02', '030' => '033', '0340' => '0369', '03700' => '03999', '04' => '19', '200' => '699', '7000' => '8499', '85000' => '89999', '900000' => '949999', '9500000' => '9539999', '95400' => '96999', '9700000' => '9899999', '99000' => '99499', '99500' => '99999') ),
         '4'    => array('Japan' => array('00' => '19', '200' => '699', '7000' => '8499', '85000' => '89999', '900000' => '949999', '9500000' => '9999999') ),
         '5'    => array('Russian Federation' => array('00' => '19', '200' => '420', '4210' => '4299', '430' => '430', '4310' => '4399', '440' => '440', '4410' => '4499', '450' => '699', '7000' => '8499', '85000' => '89999', '900000' => '909999', '91000' => '91999', '9200' => '9299', '93000' => '94999', '9500' => '9799', '98000' => '98999', '9900000' => '9909999', '9910' => '9999') ),
         '600'  => array('Iran' => array('00' => '09', '100' => '499', '5000' => '8999', '90000' => '99999') ),
         '601'  => array('Kazakhstan' => array('00' => '19', '200' => '699', '7000' => '7999', '80000' => '84999', '85' => '99') ),
         '602'  => array('Indonesia' => array('00' => '19', '200' => '799', '8000' => '9499', '95000' => '99999') ),
         '603'  => array('Saudi Arabia' => array('00' => '04', '500' => '799', '8000' => '8999', '90000' => '99999') ),
         '604'  => array('Vietnam' => array('0' => '4', '50' => '89', '900' => '979', '9800' => '9999') ),
         '605'  => array('Turkey' => array('00' => '09', '100' => '399', '4000' => '5999', '60000' => '89999') ),
         '606'  => array('Romania' => array('0' => '0', '10' => '49', '500' => '799', '8000' => '9199', '92000' => '99999') ),
         '607'  => array('Mexico' => array('00' => '39', '400' => '749', '7500' => '9499', '95000' => '99999') ),
         '608'  => array('Macedonia' => array('0' => '0', '10' => '19', '200' => '449', '4500' => '6499', '65000' => '69999', '7' => '9') ),
         '609'  => array('Lithuania' => array('00' => '39', '400' => '799', '8000' => '9499', '95000' => '99999') ),
         '610'  => array('Thailand' => array('00' => '19', '200' => '699', '7000' => '8999', '90000' => '99999') ),
         '611'  => array('Ukraine' => array('00' => '49', '500' => '699', '7000' => '8999', '90000' => '99999') ),
         '7'    => array('China, People\'s Republic' => array('00' => '09', '100' => '499', '5000' => '7999', '80000' => '89999', '900000' => '999999') ),
         '80'   => array('Czech Republic; Slovakia' => array('00' => '19', '200' => '699', '7000' => '8499', '85000' => '89999', '900000' => '999999') ),
         '81'   => array('India' => array('00' => '19', '200' => '699', '7000' => '8499', '85000' => '89999', '900000' => '999999') ),
         '82'   => array('Norway' => array('00' => '19', '200' => '699', '7000' => '8999', '90000' => '98999', '990000' => '999999') ),
         '83'   => array('Poland' => array('00' => '19', '200' => '599', '60000' => '69999', '7000' => '8499', '85000' => '89999', '900000' => '999999') ),
         '84'   => array('Spain' => array('00' => '19', '200' => '699', '7000' => '8499', '85000' => '89999', '9000' => '9199', '920000' => '923999', '92400' => '92999', '930000' => '949999', '95000' => '96999', '9700' => '9999') ),
         '85'   => array('Brazil' => array('00' => '19', '200' => '599', '60000' => '69999', '7000' => '8499', '85000' => '89999', '900000' => '979999', '98000' => '99999') ),
         '86'   => array('Serbia and Montenegro' => array('00' => '29', '300' => '599', '6000' => '7999', '80000' => '89999', '900000' => '999999') ),
         '87'   => array('Denmark' => array('00' => '29', '400' => '649', '7000' => '7999', '85000' => '94999', '970000' => '999999') ),
         '88'   => array('Italian speaking area' => array('00' => '19', '200' => '599', '6000' => '8499', '85000' => '89999', '900000' => '949999', '95000' => '99999') ),
         '89'   => array('Korea' => array('00' => '24', '250' => '549', '5500' => '8499', '85000' => '94999', '950000' => '999999') ),
         '90'   => array('Netherlands, Belgium (Flemish)' => array('00' => '19', '200' => '499', '5000' => '6999', '70000' => '79999', '800000' => '849999', '8500' => '8999', '900000' => '909999', '940000' => '949999') ),
         '91'   => array('Sweden' => array('0' => '1', '20' => '49', '500' => '649', '7000' => '7999', '85000' => '94999', '970000' => '999999') ),
         '92'   => array('International Publishers (Unesco, EU), European Community Organizations' => array('0' => '5', '60' => '79', '800' => '899', '9000' => '9499', '95000' => '98999', '990000' => '999999') ),
         '93'   => array('India' => array('00' => '09', '100' => '499', '5000' => '7999', '80000' => '94999', '950000' => '999999') ),
         '94'   => array('Netherlands' => array('000' => '599', '6000' => '8999', '90000' => '99999') ),
         '950'  => array('Argentina' => array('00' => '49', '500' => '899', '9000' => '9899', '99000' => '99999') ),
         '951'  => array('Finland' => array('0' => '1', '20' => '54', '550' => '889', '8900' => '9499', '95000' => '99999') ),
         '952'  => array('Finland' => array('00' => '19', '200' => '499', '5000' => '5999', '60' => '65', '6600' => '6699', '67000' => '69999', '7000' => '7999', '80' => '94', '9500' => '9899', '99000' => '99999') ),
         '953'  => array('Croatia' => array('0' => '0', '10' => '14', '150' => '549', '55000' => '59999', '6000' => '9499', '95000' => '99999') ),
         '954'  => array('Bulgaria' => array('00' => '29', '300' => '799', '8000' => '8999', '90000' => '92999', '9300' => '9999') ),
         '955'  => array('Sri Lanka' => array('0000' => '0999', '1000' => '1999', '20' => '54', '550' => '799', '8000' => '9499', '95000' => '99999') ),
         '956'  => array('Chile' => array('00' => '19', '200' => '699', '7000' => '9999') ),
         '957'  => array('Taiwan, China' => array('00' => '02', '0300' => '0499', '05' => '19', '2000' => '2099', '21' => '27', '28000' => '30999', '31' => '43', '440' => '819', '8200' => '9699', '97000' => '99999') ),
         '958'  => array('Colombia' => array('00' => '56', '57000' => '59999', '600' => '799', '8000' => '9499', '95000' => '99999') ),
         '959'  => array('Cuba' => array('00' => '19', '200' => '699', '7000' => '8499') ),
         '960'  => array('Greece' => array('00' => '19', '200' => '659', '6600' => '6899', '690' => '699', '7000' => '8499', '85000' => '99999') ),
         '961'  => array('Slovenia' => array('00' => '19', '200' => '599', '6000' => '8999', '90000' => '94999') ),
         '962'  => array('Hong Kong' => array('00' => '19', '200' => '699', '7000' => '8499', '85000' => '86999', '8700' => '8999', '900' => '999') ),
         '963'  => array('Hungary' => array('00' => '19', '200' => '699', '7000' => '8499', '85000' => '89999', '9000' => '9999') ),
         '964'  => array('Iran' => array('00' => '14', '150' => '249', '2500' => '2999', '300' => '549', '5500' => '8999', '90000' => '96999', '970' => '989', '9900' => '9999') ),
         '965'  => array('Israel' => array('00' => '19', '200' => '599', '7000' => '7999', '90000' => '99999') ),
         '966'  => array('Ukraine' => array('00' => '14', '1500' => '1699', '170' => '199', '2000' => '2999', '300' => '699', '7000' => '8999', '90000' => '99999') ),
         '967'  => array('Malaysia' => array('00' => '29', '300' => '499', '5000' => '5999', '60' => '89', '900' => '989', '9900' => '9989', '99900' => '99999') ),
         '968'  => array('Mexico' => array('01' => '39', '400' => '499', '5000' => '7999', '800' => '899', '9000' => '9999') ),
         '969'  => array('Pakistan' => array('0' => '1', '20' => '39', '400' => '799', '8000' => '9999') ),
         '970'  => array('Mexico' => array('01' => '59', '600' => '899', '9000' => '9099', '91000' => '96999', '9700' => '9999') ),
         '971'  => array('Philippines' => array('000' => '019', '02' => '02', '0300' => '0599', '06' => '09', '10' => '49', '500' => '849', '8500' => '9099', '91000' => '99999') ),
         '972'  => array('Portugal' => array('0' => '1', '20' => '54', '550' => '799', '8000' => '9499', '95000' => '99999') ),
         '973'  => array('Romania' => array('0' => '0', '100' => '169', '1700' => '1999', '20' => '54', '550' => '759', '7600' => '8499', '85000' => '88999', '8900' => '9499', '95000' => '99999') ),
         '974'  => array('Thailand' => array('00' => '19', '200' => '699', '7000' => '8499', '85000' => '89999', '90000' => '94999', '9500' => '9999') ),
         '975'  => array('Turkey' => array('00000' => '00999', '01' => '24', '250' => '599', '6000' => '9199', '92000' => '98999', '990' => '999') ),
         '976'  => array('Caribbean Community' => array('0' => '3', '40' => '59', '600' => '799', '8000' => '9499', '95000' => '99999') ),
         '977'  => array('Egypr' => array('00' => '19', '200' => '499', '5000' => '6999', '700' => '999') ),
         '978'  => array('Nigeria' => array('000' => '199', '2000' => '2999', '30000' => '79999', '8000' => '8999', '900' => '999') ),
         '979'  => array('Indonesia' => array('000' => '099', '1000' => '1499', '15000' => '19999', '20' => '29', '3000' => '3999', '400' => '799', '8000' => '9499', '95000' => '99999') ),
         '980'  => array('Venezuela' => array('00' => '19', '200' => '599', '6000' => '9999') ),
         '981'  => array('Singapore' => array('00' => '11', '120' => '299', '3000' => '9999') ),
         '982'  => array('South Pacific' => array('00' => '09', '100' => '699', '70' => '89', '9000' => '9999') ),
         '983'  => array('Malaysia' => array('00' => '01', '020' => '199', '2000' => '3999', '40000' => '44999', '45' => '49', '50' => '79', '800' => '899', '9000' => '9899', '99000' => '99999') ),
         '984'  => array('Bangladesh' => array('00' => '39', '400' => '799', '8000' => '8999', '90000' => '99999') ),
         '985'  => array('Belarus' => array('00' => '39', '400' => '599', '6000' => '8999', '90000' => '99999') ),
         '986'  => array('Taiwan, China' => array('00' => '11', '120' => '559', '5600' => '7999', '80000' => '99999') ),
         '987'  => array('Argentina' => array('00' => '09', '1000' => '1999', '20000' => '29999', '30' => '49', '500' => '899', '9000' => '9499', '95000' => '99999') ),
         '988'  => array('Hongkong' => array('00' => '16', '17000' => '19999', '200' => '799', '8000' => '9699', '97000' => '99999') ),
         '989'  => array('Portugal' => array('0' => '1', '20' => '54', '550' => '799', '8000' => '9499', '95000' => '99999') ),
         '9933' => array('Syria' => array('0' => '0', '10' => '39', '400' => '899', '9000' => '9999') ),
         '9934' => array('Latvia' => array('0' => '0', '10' => '49', '500' => '799', '8000' => '9999') ),
         '9935' => array('Iceland' => array('0' => '0', '10' => '39', '400' => '899', '9000' => '9999') ),
         '9936' => array('Afghanistan' => array('0' => '1', '20' => '39', '400' => '799', '8000' => '9999') ),
         '9937' => array('Nepal' => array('0' => '2', '30' => '49', '500' => '799', '8000' => '9999') ),
         '9938' => array('Tunisia' => array('00' => '79', '800' => '949', '9500' => '9999') ),
         '9939' => array('Armenia' => array('0' => '4', '50' => '79', '800' => '899', '9000' => '9999') ),
         '9940' => array('Montenegro' => array('0' => '1', '20' => '49', '500' => '899', '9000' => '9999') ),
         '9941' => array('Georgia' => array('0' => '0', '10' => '39', '400' => '899', '9000' => '9999') ),
         '9942' => array('Ecuador' => array('00' => '89', '900' => '994', '9950' => '9999') ),
         '9943' => array('Uzbekistan' => array('00' => '29', '300' => '399', '4000' => '9999') ),
         '9944' => array('Turkey' => array('0' => '2', '300' => '499', '5000' => '5999', '60' => '89', '900' => '999') ),
         '9945' => array('Dominican Republic' => array('00' => '00', '010' => '079', '08' => '39', '400' => '569', '57' => '57', '580' => '849', '8500' => '9999') ),
         '9946' => array('Korea, P.D.R.' => array('0' => '1', '20' => '39', '400' => '899', '9000' => '9999') ),
         '9947' => array('Algeria' => array('0' => '1', '20' => '79', '800' => '999') ),
         '9948' => array('United Arab Emirates' => array('00' => '39', '400' => '849', '8500' => '9999') ),
         '9949' => array('Estonia' => array('0' => '0', '10' => '39', '400' => '899', '9000' => '9999') ),
         '9950' => array('Palestine' => array('00' => '29', '300' => '840', '8500' => '9999') ),
         '9951' => array('Kosova' => array('00' => '39', '400' => '849', '8500' => '9999') ),
         '9952' => array('Azerbaijan' => array('0' => '1', '20' => '39', '400' => '799', '8000' => '9999') ),
         '9953' => array('Lebanon' => array('0' => '0', '10' => '39', '400' => '599', '60' => '89', '9000' => '9999') ),
         '9954' => array('Morocco' => array('0' => '1', '20' => '39', '400' => '799', '8000' => '9999') ),
         '9955' => array('Lithuania' => array('00' => '39', '400' => '929', '9300' => '9999') ),
         '9956' => array('Cameroon' => array('0' => '0', '10' => '39', '400' => '899', '9000' => '9999') ),
         '9957' => array('Jordan' => array('00' => '39', '400' => '699', '70' => '84', '8500' => '9999') ),
         '9958' => array('Bosnia and Herzegovina' => array('0' => '0', '10' => '49', '500' => '899', '9000' => '9999') ),
         '9959' => array('Libya' => array('0' => '1', '20' => '79', '800' => '949', '9500' => '9999') ),
         '9960' => array('Saudi Arabia' => array('00' => '59', '600' => '899', '9000' => '9999') ),
         '9961' => array('Algeria' => array('0' => '2', '30' => '69', '700' => '949', '9500' => '9999') ),
         '9962' => array('Panama' => array('00' => '54', '5500' => '5599', '56' => '59', '600' => '849', '8500' => '9999') ),
         '9963' => array('Cyprus' => array('0' => '2', '30' => '54', '550' => '749', '7500' => '9999') ),
         '9964' => array('Ghana' => array('0' => '6', '70' => '94', '950' => '999') ),
         '9965' => array('Kazakhstan' => array('00' => '39', '400' => '899', '9000' => '9999') ),
         '9966' => array('Kenya' => array('000' => '199', '20' => '69', '7000' => '7499', '750' => '959', '9600' => '9999') ),
         '9967' => array('Kyrgyzstan' => array('00' => '39', '400' => '899', '9000' => '9999') ),
         '9968' => array('Costa Rica' => array('00' => '49', '500' => '939', '9400' => '9999') ),
         '9970' => array('Uganda' => array('00' => '39', '400' => '899', '9000' => '9999') ),
         '9971' => array('Singapore' => array('0' => '5', '60' => '89', '900' => '989', '9900' => '9999') ),
         '9972' => array('Peru' => array('00' => '09', '1' => '1', '200' => '249', '2500' => '2999', '30' => '59', '600' => '899', '9000' => '9999') ),
         '9973' => array('Tunisia' => array('00' => '05', '060' => '089', '0900' => '0999', '10' => '69', '700' => '969', '9700' => '9999') ),
         '9974' => array('Uruguay' => array('0' => '2', '30' => '54', '550' => '749', '7500' => '9499', '95' => '99') ),
         '9975' => array('Moldova' => array('0' => '0', '100' => '399', '4000' => '4499', '45' => '89', '900' => '949', '9500' => '9999') ),
         '9976' => array('Tanzania' => array('0' => '5', '60' => '89', '900' => '989', '9990' => '9999') ),
         '9977' => array('Costa Rica' => array('00' => '89', '900' => '989', '9900' => '9999') ),
         '9978' => array('Ecuador' => array('00' => '29', '300' => '399', '40' => '94', '950' => '989', '9900' => '9999') ),
         '9979' => array('Iceland' => array('0' => '4', '50' => '64', '650' => '659', '66' => '75', '760' => '899', '9000' => '9999') ),
         '9980' => array('Papua New Guinea' => array('0' => '3', '40' => '89', '900' => '989', '9900' => '9999') ),
         '9981' => array('Morocco' => array('00' => '09', '100' => '159', '1600' => '1999', '20' => '79', '800' => '949', '9500' => '9999') ),
         '9982' => array('Zambia' => array('00' => '79', '800' => '989', '9900' => '9999') ),
         '9983' => array('Gambia' => array('80' => '94', '950' => '989', '9900' => '9999') ),
         '9984' => array('Latvia' => array('00' => '49', '500' => '899', '9000' => '9999') ),
         '9985' => array('Estonia' => array('0' => '4', '50' => '79', '800' => '899', '9000' => '9999') ),
         '9986' => array('Lithuania' => array('00' => '39', '400' => '899', '9000' => '9399', '940' => '969', '97' => '99') ),
         '9987' => array('Tanzania' => array('00' => '39', '400' => '879', '8800' => '9999') ),
         '9988' => array('Ghana' => array('0' => '2', '30' => '54', '550' => '749', '7500' => '9999') ),
         '9989' => array('Macedonia' => array('0' => '0', '100' => '199', '2000' => '2999', '30' => '59', '600' => '949', '9500' => '9999') ),
         '99901' => array('Bahrain' => array('00' => '49', '500' => '799', '80' => '99') ),
         '99902' => array('Gabon' => array() ),
         '99903' => array('Mauritius' => array('0' => '1', '20' => '89', '900' => '999') ),
         '99904' => array('Netherlands Antilles; Aruba, Neth. Ant' => array('0' => '5', '60' => '89', '900' => '999') ),
         '99905' => array('Bolivia' => array('0' => '3', '40' => '79', '800' => '999') ),
         '99906' => array('Kuwait' => array('0' => '2', '30' => '59', '600' => '699', '70' => '89', '9' => '9') ),
         '99908' => array('Malawi' => array('0' => '0', '10' => '89', '900' => '999') ),
         '99909' => array('Malta' => array('0' => '3', '40' => '94', '950' => '999') ),
         '99910' => array('Sierra Leone' => array('0' => '2', '30' => '89', '900' => '999') ),
         '99911' => array('Lesotho' => array('00' => '59', '600' => '999') ),
         '99912' => array('Botswana' => array('0' => '3', '400' => '599', '60' => '89', '900' => '999') ),
         '99913' => array('Andorra' => array('0' => '2', '30' => '35', '600' => '604') ),
         '99914' => array('Suriname' => array('0' => '4', '50' => '89', '900' => '949') ),
         '99915' => array('Maldives' => array('0' => '4', '50' => '79', '800' => '999') ),
         '99916' => array('Namibia' => array('0' => '2', '30' => '69', '700' => '999') ),
         '99917' => array('Brunei Darussalam' => array('0' => '2', '30' => '89', '900' => '999') ),
         '99918' => array('Faroe Islands' => array('0' => '3', '40' => '79', '800' => '999') ),
         '99919' => array('Benin' => array('0' => '2', '300' => '399', '40' => '69', '900' => '999') ),
         '99920' => array('Andorra' => array('0' => '4', '50' => '89', '900' => '999') ),
         '99921' => array('Qatar' => array('0' => '1', '20' => '69', '700' => '799', '8' => '8', '90' => '99') ),
         '99922' => array('Guatemala' => array('0' => '3', '40' => '69', '700' => '999') ),
         '99923' => array('El Salvador' => array('0' => '1', '20' => '79', '800' => '999') ),
         '99924' => array('Nicaragua' => array('0' => '1', '20' => '79', '800' => '999') ),
         '99925' => array('Paraguay' => array('0' => '3', '40' => '79', '800' => '999') ),
         '99926' => array('Honduras' => array('0' => '0', '10' => '59', '600' => '999') ),
         '99927' => array('Albania' => array('0' => '2', '30' => '59', '600' => '999') ),
         '99928' => array('Georgia' => array('0' => '0', '10' => '79', '800' => '999') ),
         '99929' => array('Mongolia' => array('0' => '4', '50' => '79', '800' => '999') ),
         '99930' => array('Armenia' => array('0' => '4', '50' => '79', '800' => '999') ),
         '99931' => array('Seychelles' => array('0' => '4', '50' => '79', '800' => '999') ),
         '99932' => array('Malta' => array('0' => '0', '10' => '59', '600' => '699', '7' => '7', '80' => '99') ),
         '99933' => array('Nepal' => array('0' => '2', '30' => '59', '600' => '999') ),
         '99934' => array('Dominican Republic' => array('0' => '1', '20' => '79', '800' => '999') ),
         '99935' => array('Haiti' => array('0' => '2', '7' => '8', '30' => '59', '600' => '699', '90' => '99') ),
         '99936' => array('Bhutan' => array('0' => '0', '10' => '59', '600' => '999') ),
         '99937' => array('Macau' => array('0' => '1', '20' => '59', '600' => '999') ),
         '99938' => array('Srpska' => array('0' => '1', '20' => '59', '600' => '899', '90' => '99') ),
         '99939' => array('Guatemala' => array('0' => '5', '60' => '89', '900' => '999') ),
         '99940' => array('Georgia' => array('0' => '0', '10' => '69', '700' => '999') ),
         '99941' => array('Armenia' => array('0' => '2', '30' => '79', '800' => '999') ),
         '99942' => array('Sudan' => array('0' => '4', '50' => '79', '800' => '999') ),
         '99943' => array('Alsbania' => array('0' => '2', '30' => '59', '600' => '999') ),
         '99944' => array('Ethiopia' => array('0' => '4', '50' => '79', '800' => '999') ),
         '99945' => array('Namibia' => array('0' => '5', '60' => '89', '900' => '999') ),
         '99946' => array('Nepal' => array('0' => '2', '30' => '59', '600' => '999') ),
         '99947' => array('Tajikistan' => array('0' => '2', '30' => '69', '700' => '999') ),
         '99948' => array('Eritrea' => array('0' => '4', '50' => '79', '800' => '999') ),
         '99949' => array('Mauritius' => array('0' => '1', '20' => '89', '900' => '999') ),
         '99950' => array('Cambodia' => array('0' => '4', '50' => '79', '800' => '999') ),
         '99951' => array('Congo' => array() ),
         '99952' => array('Mali' => array('0' => '4', '50' => '79', '800' => '999') ),
         '99953' => array('Paraguay' => array('0' => '2', '30' => '79', '800' => '999') ),
         '99954' => array('Bolivia' => array('0' => '2', '30' => '69', '700' => '999') ),
         '99955' => array('Srpska' => array('0' => '1', '20' => '59', '600' => '899', '90' => '99') ),
         '99956' => array('Albania' => array('00' => '59', '600' => '999') ),
         '99957' => array('Malta' => array('0' => '1', '20' => '79', '800' => '999') ),
         '99958' => array('Bahrain' => array('0' => '4', '50' => '94', '950' => '999') ),
         '99959' => array('Luxembourg' => array('0' => '2', '30' => '59', '600' => '999') ),
         '99960' => array('Malawi' => array('0' => '0', '10' => '94', '950' => '999') ),
         '99961' => array('El Salvador' => array('0' => '3', '40' => '89', '900' => '999') ),
        );
    }

    // i cheat a little bit here.  i know that that the max length is
    // 5, and that i know that those will start with 999xx. :)
    // however, if the data changes i should think about this again.
    public static function generate_max_group_code_length()
    {
        $group_data = self::group_data();
        krsort($group_data, SORT_NUMERIC);

        // This seems like a clunky way to find the last key, but can't
        // find a better way yet in PHP:
        foreach ($group_data as $group_code => $values) {
            $longest_key = $group_code;
            break;
        }
        return strlen($longest_key);
    }

/*
 * These methods don't seem to get called anywhere...

sub isbn_group_code_string_from_number
	{
	return $Business::ISBN::country_data{ $_[0] }[0] || '';
	}

sub isbn_publisher_ranges_from_group_number
	{
	return $Business::ISBN::country_data{ $_[0] }[1] || [];
	}
*/

} // end class ISBN_Data

?>

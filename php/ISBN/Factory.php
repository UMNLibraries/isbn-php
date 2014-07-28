<?php

require_once 'ISBN.php';

class ISBN_Factory
{
    public static function create( $input_isbn )
    {
       $normalized_isbn = ISBN::normalize( $input_isbn ); 
       $class = 'ISBN' . strlen( $normalized_isbn );

       // TODO: Add exception-handling here:
       require_once $class . '.php';

       return new $class(array(
           'input_isbn' => $input_isbn,
           'isbn' => $normalized_isbn,
       ));
       
    }
}

?>

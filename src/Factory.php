<?php

namespace UmnLib\Core\Isbn;

class Factory
{
  public static function create($inputIsbn)
  {
    $normalizedIsbn = Isbn::normalize($inputIsbn); 
    $class = __NAMESPACE__ . '\\' . 'Isbn' . strlen($normalizedIsbn);

    return new $class(array(
      'inputIsbn' => $inputIsbn,
      'isbn' => $normalizedIsbn,
    ));

  }
}

<?php namespace orm\objects;

class AbstractObject
{
  private $_translate;

  public function __construct($translate)
  {
    $this->_translate = $translate;
  }

  protected function con()
  {
    return $this->_translate;
  }
}
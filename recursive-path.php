<?php namespace orm;

class recursivepath
{
  public $path;
  public $hole;

  public function __construct()
  {
    $this->path = [];
    $this->hole = [];
  }

  public function dig($direction)
  {
    if (isset($this->hole[$direction]))
      die("Cannot dig path to $direction. Already was there");

    $this->path[$direction] = 'path_dummy';
    array_push($this->hole, $direction);
  }

  public function pop()
  {
    $key = array_pop($this->hole);
    unset($this->path[$key]);
  }

  public function update($val)
  {
    $this->path[end($this->hole)] = $val;
  }

  public function __debugInfo()
  {
    return $this->path;
  }

  public function __get($name)
  {
    return $this->path[$name];
  }

  public function __toString()
  {
    return $this->get();
  }

  public function get($delimeter = ".")
  {
    return implode($delimeter, $this->path);
  }
}
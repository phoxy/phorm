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
    $key = end($this->hole);
    $this->path[$key] = $val;
  }

  public function __debugInfo()
  {
    return $this->path;
  }
}
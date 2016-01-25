<?php namespace orm\objects;

include('abstract.php');

class database extends AbstractObject
{
  public function Init($name, $yaml, $path)
  {    
    var_dump($name, $yaml, $path);
    if (!$this->Exist($name))
      $this->Create($name, $yaml, $path);
  }

  public function Exist($name)
  {
    return $this->con()->ExistDatabase($name);
  }

  public function Create($name, $yaml, $path)
  {
    $this->con()->CreateTable($name, $yaml);
  }
}

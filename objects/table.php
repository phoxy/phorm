<?php namespace orm\objects;

require_once('abstract.php');

class table extends AbstractObject
{
  public function Init($name, $yaml, $path)
  {    
    if (!$this->Exist($name))
      $this->Create($name, $yaml, $path);
  }

  public function Exist($name)
  {
    return $this->con()->ExistTable($name);
  }

  public function Create($name, $yaml, $path)
  {
    $this->con()->CreateTable($name, $yaml);
  }

  public function CanRecursive()
  {
    return ["field"];
  }
}

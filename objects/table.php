<?php namespace orm\objects;

require_once('abstract.php');

class table extends AbstractObject
{
  public function Init($name, $yaml, $path)
  {    
    if (!$this->Exist($path))
      $this->Create($path, $yaml);
  }

  public function Exist($path)
  {
    return $this->con()->ExistTable($path);
  }

  public function Create($path, $yaml)
  {
    $this->con()->CreateTable($path, $yaml);
  }

  public function CanRecursive()
  {
    return ["field"];
  }
}

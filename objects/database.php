<?php namespace orm\objects;

require_once('abstract.php');

class database extends AbstractObject
{
  public function Init($name, $yaml, $path)
  {    
    if (!$this->Exist($name))
      $this->Create($name, $yaml, $path);
  }

  public function Exist($name)
  {
    return $this->con()->ExistDatabase($name);
  }

  public function Create($name, $yaml, $path)
  {
    $this->con()->CreateDatabase($name, $yaml);
    if (!$this->Exist($name))
      throw "Failed to create $name database";
  }

  public function CanRecursive()
  {
    return ["table"];
  }
}

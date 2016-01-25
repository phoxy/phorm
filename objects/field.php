<?php namespace orm\objects;

require_once('abstract.php');

class field extends AbstractObject
{
  public function Init($name, $yaml, $path)
  {    
    if (!$this->Exist($name))
      $this->Create($name, $yaml, $path);
  }

  public function Exist($name)
  {
    return $this->con()->ExistField($name);
  }

  public function Create($name, $yaml, $path)
  {
    $this->con()->CreateField($name, $yaml);
  }

  public function CanRecursive()
  {
    return [];
  }
}

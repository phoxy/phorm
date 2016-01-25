<?php namespace orm\objects;

require_once('abstract.php');

class field extends AbstractObject
{
  public function Init($name, $yaml, $path)
  {    
    if (!$this->Exist($path))
      $this->Create($path, $yaml);
  }

  public function Exist($path)
  {
    return $this->con()->ExistField($path);
  }

  public function Create($path, $yaml)
  {
    $this->con()->CreateField($path, $yaml);
  }

  public function CanRecursive()
  {
    return [];
  }
}

<?php namespace orm\objects;

require_once('abstract.php');

class database extends AbstractObject
{
  public function Init($name, $yaml, $path)
  {    
    if (!$this->Exist($path))
      $this->Create($path, $yaml);
  }

  public function Exist($path)
  {
    return $this->con()->ExistDatabase($path);
  }

  public function Create($path, $yaml)
  {
    $this->con()->CreateDatabase($path, $yaml);
    if (!$this->Exist($path))
      die("Failed to create {$path->database} database");
  }

  public function CanRecursive()
  {
    return ["table"];
  }
}

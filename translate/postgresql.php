<?php namespace orm\translate;

class postgresql
{
  public function ExistDatabase($name)
  {
    $ret = \db::Query("SELECT count(*) FROM pg_catalog.pg_database WHERE datname=$1", [$name], true);
    return $ret->count;
  }

  public function CreateDatabase($name, $settings)
  {
    \db::Query("CREATE DATABASE $name");
  }

  public function ExistTable($settings)
  {
    
  }

  public function CreateTable($settings)
  {

  }

  public function ExistField($settings)
  {
    
  }

  public function CreateField($settings)
  {

  }

  public function ExistKey($settings)
  {
    
  }

  public function CreateKey($settings)
  {

  }
}
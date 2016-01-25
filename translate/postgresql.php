<?php namespace orm\translate;

class postgresql
{
  public function ExistDatabase($path)
  {
    $ret = \db::Query("SELECT count(*) FROM pg_catalog.pg_database WHERE datname=$1", [$path->database], true);
    return $ret->count;
  }

  public function CreateDatabase($path, $settings)
  {
    \db::Query("CREATE DATABASE {$path->database}");
  }

  public function ExistTable($path)
  {
    if (!isset($path->schema))
      $schema = 'public';
    else
      $schema = $path->schema;

    $table = $path->table;

    $ret = \db::Query("SELECT EXISTS (
        SELECT 1 
        FROM   pg_catalog.pg_class c
        JOIN   pg_catalog.pg_namespace n ON n.oid = c.relnamespace
        WHERE  n.nspname = $1
        AND    c.relname = $2
        AND    c.relkind = 'r'    -- only tables(?)
        )", [$schema, $table], true);
    
    return $res->exists == 't';
  }

  public function CreateTable($path, $settings)
  {
    die('create table');
  }

  public function ExistField($path)
  {
    
  }

  public function CreateField($path, $settings)
  {

  }

  public function ExistKey($path)
  {
    
  }

  public function CreateKey($path, $settings)
  {

  }
}
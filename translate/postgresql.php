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

  public function Schema($path)
  {
    if (!isset($path->schema))
      return 'public';
    return $path->schema;
  }

  public function Table($path)
  {
    return "{$this->Schema($path)}.{$path->table}";
  }

  public function ExistTable($path)
  {
    $ret = \db::Query("SELECT EXISTS (
        SELECT 1
        FROM   pg_catalog.pg_class c
        JOIN   pg_catalog.pg_namespace n ON n.oid = c.relnamespace
        WHERE  n.nspname = $1
        AND    c.relname = $2
        AND    c.relkind = 'r'    -- only tables(?)
        )", [$this->Schema($path), $path->table], true);

    return $ret->exists == 't';
  }

  public function CreateTable($path, $settings)
  {
    \db::Query("CREATE TABLE {$this->Table($path)}()");
  }

  public function ExistField($path)
  {
    $ret = \db::Query("SELECT * FROM information_schema.columns
      WHERE table_schema=$1
        and table_name=$2
        and column_name=$3",
        [$this->Schema($path), $path->table, $path->field], true);

    if (!$ret())
      return false;

    var_dump($ret);
    return $ret;
  }

  public function CreateField($path, $settings)
  {
    var_dump($settings);

    var_dump("ALTER TABLE {$this->Table($path)}
      ADD COLUMN {$path->field}");
  }

  public function ExistKey($path)
  {

  }

  public function CreateKey($path, $settings)
  {

  }
}
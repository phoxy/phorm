<?php namespace orm\translate;

require_once('abstract.php');

class postgresql
{
  public function ExistDatabase($path)
  {
    $ret = \db::SafeQuery("SELECT count(*) FROM pg_catalog.pg_database WHERE datname=$1", [$path->database], true);
    return $ret->count;
  }

  public function CreateDatabase($path, $settings)
  {
    \db::SafeQuery("CREATE DATABASE {$path->database}");
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
    $ret = \db::SafeQuery("SELECT EXISTS (
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
    \db::SafeQuery("CREATE TABLE {$this->Table($path)}()");
  }

  public function ExistField($path)
  {
    $ret = \db::SafeQuery("SELECT * FROM information_schema.columns
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
    $type = "varchar";

    if (!in_array($settings[0], AbstractTranslate::$types))
      $type = $settings[0];

    $append = "";
    if (in_array("primary", $settings))
      $append .= "ALTER TABLE {$this->Table($path)} ADD PRIMARY KEY ($path->field)";
    else if (in_array("unique", $settings))
      $append .= "ALTER TABLE {$this->Table($path)} ADD UNIQUE ($path->field)";

    if (in_array("increment", $settings))
      $type = "serial";


    \db::SafeQuery("ALTER TABLE {$this->Table($path)}
      ADD COLUMN {$path->field} {$type}");
    \db::SafeQuery($append);
  }

  public function ExistKey($path)
  {

  }

  public function CreateKey($path, $settings)
  {

  }
}
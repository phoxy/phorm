<?php namespace orm;

include('vendor/autoload.php');

include('translate/abstract.php');

$test = new translate\AbstractTranslate();

function PopFirstObject(&$array)
{
  $keys = array_keys($array);

  if (!count($keys))
    return null;

  $key = current($keys);
  $obj = $array[$key];
  unset($array[$key]);

  return [ $key, $obj ];
}

function GetFirstObject($array)
{
  $copy = $array;
  return PopFirstObject($copy);
}

function CanRecursive($object, $yaml)
{
  list($word, $obj) = PopFirstObject($yaml);

  $can = $object->CanRecursive();
  return in_array($word, $can);
}

include('recursive-path.php');

$path = new recursivepath();
function RecursiveRead($arr)
{
  global $test, $path;

  $types = array_keys($arr);

  foreach ($types as $type)
  {
    include("objects/{$type}.php");
    $fulltypename = "orm\\objects\\{$type}";
    $path->dig($type);

    $objects = $arr[$type];

    foreach ($objects as $settings)
    {
      list($name, $object) = PopFirstObject($settings);
      $path->update($name);
      if ($name == null)
        break;

      $bond = new $fulltypename($test);
      $bond->Init($name, $object, $path);

      if (CanRecursive($bond, $object))
        RecursiveRead($object);
    }

    $path->pop();
  }

  die('OK');
}

function ReadConfig($file)
{
  $yaml = \spyc_load_file($file);
  RecursiveRead($yaml);
}

ReadConfig('sql.yaml');


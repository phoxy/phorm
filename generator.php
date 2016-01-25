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
      if ($name == null)
        break;

      $path->update($name);      
      $bond = new $fulltypename($test);
      $bond->Init($name, $object, $path);

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


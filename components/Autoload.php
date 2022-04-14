<?php

spl_autoload_register(function ($class) {

     # List all the class directories in the array.
     $array_paths = array(
      '/models/',
      '/components/'
  );

  foreach ($array_paths as $path) {
      $path = ROOT . $path . $class . '.php';
      if (is_file($path)) {
          include_once $path;
      }
  }

});

?>
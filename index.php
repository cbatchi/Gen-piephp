<?php

// Remove executable file to array
function get_args () {
  global $argv;
  array_shift($argv);
  return $argv;
}

// Create Directory stucture
function createDirectory (array $tabs, $dir=false) {
  if (is_array($tabs)) {
    foreach ($tabs as $key => $value) {
      if (isset($key)) {
        shell_exec("mkdir $dir/$key");
        if ($key == 'Core') {
          foreach($value as $content) {
            $upper = ucfirst($content);
            shell_exec("cd $key && touch $upper.php && echo '<?php\r\rnamespace\t$key;\r\rclass\t$upper\t{\r\r}\r' > $upper.php");
          }
        } elseif ($key == 'src') {
          foreach($value as $content) {
            $upper = ucfirst($content);
            shell_exec("cd $key && mkdir $upper");
          }
        } else {
          foreach($value as $content) {
            shell_exec("cd $key && mkdir $content");
          }
        }
      }
    }
  }
}

// Run action
function run () {

  $paths = [
    "Core" => ["core","controller","database","entity","ORM","request","router"],
    "src" => ['controller','model','view'],
    'public' => ['css','js','assets']
  ];

  $currentDir = __DIR__;
  $arg = get_args(); 
  
  $actions = ['create','update','delete'];

  if ($arg[0] == $actions[0]) { createDirectory($paths ,$currentDir); }
  else { return false; exit(); }
  // Ask for empty content index.php
  echo "Les dossiers ont été créer" . "\n\n";
  echo "T'es à présent prêt à bosser\n\n";

  $ask = (string) readline('Un dernier details! veux tu reset ce fichier index.php ? [O/N]');
  if ($ask === "O") {
    shell_exec("echo '' > ./index.php && echo '<?php\r\r' > ./index.php && rm -rf readme.md");
  } elseif($ask === "N") {
    echo 'Operation abandonné :)' . PHP_EOL;
    return false;
  }
}

// Run app
run();

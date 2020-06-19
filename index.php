<?php


// Remove executable file index to array
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
            shell_exec("cd $key && mkdir $upper && touch ./routes.php && echo '<?php\r\r' > ./routes.php");
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

// Run function
function run () {

  // Directory names
  $paths = [
    "Core" => ["core","controller","database","entity","ORM","request","router","templateEngine"],
    "src" => ['controller','model','view'],
    'public' => ['css','js','assets']
  ];

  // Current dir path
  $currentDir = __DIR__;
  $arg = get_args(); 
  
  // Actions list, just create work for the moment 
  $actions = ['create','update','delete'];
  

  // Statement if first index match with create word
  $arg[0] == $actions[0] ? createDirectory($paths ,$currentDir) : false;
  
  // Ask for empty content index.php
  echo '| ================================= |' . "\n\n\r";
    echo "  Le skeleton mvc a bien été créer" . "\n\n";
  echo '| ================================= |' . "\n\n\r";

  // Ask question for delete content of index file for start coding
  $ask = (string) readline('Un dernier detail! souhaites tu vider le contenu du fichier index ? [O/N] ');

  // Switch case statement if enter expected word make action
  switch ($ask) {
    
    case 'O':
      shell_exec("echo '' > ./index.php && echo '<?php\r\r'// Happy coding !!! > ./index.php && rm -rf README.md");
      return true;
    break;
    
    case 'N':
      echo 'A bientôt !' . PHP_EOL;
      return false;
    break;
    
    default:
      echo 'Aucune de ses options n\'a été reconnue';
      return false;
  }
}

// Run app
run();

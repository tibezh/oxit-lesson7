<?php


$db = array(
  'db_name' => 'lessons7',
  'db_user' => 'print_house',
  'db_pass' => '248213',
);
try {
    $dsn = "mysql:host=localhost;dbname={$db['db_name']}";
    $conn = new PDO($dsn, $db['db_user'], $db['db_pass']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    print "DB ERROR: {$e->getMessage()}";
}

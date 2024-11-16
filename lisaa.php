<?php
$mess = $_POST['mess'];
$kirj = $_POST['kirj'];

$dsn = "pgsql:host=localhost;dbname=lsaarinen";
$user = "db_lsaarinen";
$pass = getenv("DB_PASSWORD");
$options = [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION];

try {
    $yht = new PDO($dsn, $user, $pass, $options);
     if (!$yht) $e->getmessage();

if ( !empty($kirj) and !empty($mess) )
{ 
$ins = "INSERT INTO vieras VALUES ( default, :mita, :kuka, now(), now() )"; 

$lause = $yht->prepare($ins);

$lause->bindParam(':mita', $mess);
$lause->bindParam(':kuka', $kirj);


$lause->execute([$mess,$kirj]);
unset($mess);
unset($kirj);
unset($_POST);
unset($_REQUEST);
$id = $yht->lastInsertId(); 
 header("Location: index.php?id=$id"); 
}
}


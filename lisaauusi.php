<?php 

$dsn = "pgsql:host=localhost;dbname=lsaarinen";
$user = "db_lsaarinen";
$pass = getenv('DB_PASSWORD');
$options = [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION];

try {
$yht = new PDO($dsn, $user, $pass, $options);
if (!$yht) {die ();}
 

    $mess = $_POST['mess'] ;
    $kirj = $_POST['kirj'] ;

    if(!empty($mess) || !empty($kirj) )  
    { 
   

    $lisaa=("INSERT INTO vieras 
    (vid,kirj,mess,aika,pvm)
    VALUES (default,?,?,now(),now())"); 

 $lause = $yht->prepare($lisaa);
 
 $lause->execute([$kirj,$mess]); 
 $id = $yht->lastInsertId(); 
 unset($mess);
 unset($kirj);
 unset($_POST); 
 unset($_REQUEST);


header("Location: index.php?id=$id"); 
}
}
catch (PDOException $e) { 
    echo $e->getMessage(); die();
   
}
?> 
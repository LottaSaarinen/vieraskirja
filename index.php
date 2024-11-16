<?php
include 'yla.php';

$dsn = "pgsql:host=localhost;dbname=lsaarinen";
$user = "db_lsaarinen";
$pass = getenv("DB_PASSWORD");
$options = [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION];
            
try {
    $yht= new PDO($dsn, $user, $pass, $options);
    if (!$yht) { die(); }

$kys = "select * from vieras order by vid asc";
$lause = $yht->prepare($kys);
$lause->execute();

        echo "<hr>";
        while ( $tulos = $lause->fetchObject() ) {
            echo "<font size=2><b>";
            echo $tulos->kirj . "</b> kirjoitti ";
            echo $tulos->pvm . " klo " . substr($tulos->aika, 0, 8);
            echo "</font><p><b>";
            echo $tulos->mess;
            echo "</b></p><hr>";
            
        }
    }
     
catch (PDOException $e) {
    echo $e->getMessage();
    die();
}
include 'ala.php';
?>

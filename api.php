<?php
$method = $_SERVER['REQUEST_METHOD'];

$dsn ="pgsql:host=localhost;dbname=lsaarinen";
$user ="db_lsaarinen";
$pass=getenv('DB_PASSWORD');
$options =[PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION];

try {
$yht = new PDO($dsn, $user, $pass, $options);
if (!$yht) {die(); }

switch ($method) {
	case 'GET':
		$sql = "select * from vieras";
		$lause= $yht->prepare($sql);
		$lause->execute();

	while ( $tulos = $lause->fetchObject () ) { 
// niin kauan kun lauseita riittää on tosi/true. False heti kuin ei lauseita enään löydy

		    echo $tulos->vid . "\n";
		    echo $tulos->mess . "\n";
        	echo $tulos->kirj . "\n";
		    echo $tulos->aika . "\n";
        	echo $tulos->pvm . "\n";
		   
		    echo "==============\n";
        }
	break;


case 'POST'; 
    $sql = "insert into vieras values (?,?,?,?,?)";
	$lause = $yht->prepare($sql);

	$jdata = file_get_contents('php://input');
	$data = json_decode($jdata);


	$lause->bindValue(1, $data->vid);
	$lause->bindValue(2, $data->mess);	
	$lause->bindValue(3, $data->kirj);	
	$lause->bindValue(4, $data->aika);	
	$lause->bindValue(5, $data->pvm);
    
	$lause->execute();

    break;
        
    }

//suljetaan yhteys
	$yht =null;

}

catch (PDOException $e) {
	echo $e->getMessage();
	die ();

}

 ?>
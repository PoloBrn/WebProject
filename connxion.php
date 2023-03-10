<?php 
//$dsn = 'mysql:host=34.155.93.202;dbname=web-project-v0'; // Serveur Google Cloud
$dsn = 'mysql:host=127.0.0.1;dbname=webproject_v0'; // Serveur Localhost

//$pdo = new PDO($dsn, 'root' , 'cesi'); // Serveur Google Cloud
$pdo = new PDO($dsn, 'root' , ''); // Serveur Localhost

// $Eleve_Result= mysql_query ( SELECT * FROM users ) ;
$stmt = $pdo->query('select * from users');

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  echo htmlspecialchars($row['email']);
  echo '<br>';
}
?>


<?php 
$dsn = 'mysql:host=34.155.93.202;dbname=web-project-v0';

$pdo = new PDO($dsn, 'root' , 'cesi'); 

// $Eleve_Result= mysql_query ( SELECT * FROM users ) ;
$stmt = $pdo->query('select * from users');

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  echo htmlspecialchars($row['email']);
  echo '<br>';
}
?>


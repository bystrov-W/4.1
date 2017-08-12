<?php

	ini_set('display_errors',1);
	error_reporting(E_ALL);
	
	//Соединение с базой данных
	$host = '127.0.0.1';
	$db = 'books';
	$charset = 'utf8';
	$user = 'root';
	$pass = '';
	
	
	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	
	$opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	);
	
	$pdo = new PDO($dsn, $user, $pass, $opt);
	
	
	if (isset($_POST['search'])) {
		$namee = isset($_POST['name']) ? $_POST['name'] : '';
		$authorr = isset($_POST['author']) ? $_POST['author'] : '';
		$isbnn = isset($_POST['isbn']) ? $_POST['isbn'] : '';
		$stmt = $pdo->prepare('SELECT * FROM books WHERE name LIKE ? AND author LIKE ? AND isbn LIKE ?');
		$stmt->execute(array("%$namee%","%$authorr%","%$isbnn%"));
	} else {
		$stmt = $pdo->query('SELECT * FROM books');
	}
?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Книги</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	</head>
	<body>
    <div class="container">
		<div class="row">
			<div class="col-md-12">
			<h1>Библиотека успешного человека</h1>
			<form role="form" action="" method="post">
				<div class="form-group">
					<label for="text">Название</label>
					<input type="text" class="form-control" name="name" value="<?php if (isset($namee)){echo $namee;}?>">
				</div>
				<div class="form-group">
					<label for="text">Автор</label>
					<input type="text" class="form-control" name="author" value="<?php if (isset($authorr)){echo $authorr;}?>">
				</div>
				<div class="form-group">
					<label for="text">ISBN</label>
					<input type="text" class="form-control" name="isbn" value="<?php if (isset($isbnn)){echo $isbnn;}?>">
				</div>
				<button type="submit" class="btn btn-success" name="search">Поиск</button>
			</form>
				<table class="table">
					<tr>
						<th>Название</th>
						<th>Автор</th>
						<th>Год выпуска</th>
						<th>Жанр</th>
						<th>ISBN</th>
					</tr>
				<?php
					while ($row = $stmt->fetch())
						{
							echo '<tr><td>' . $row['name'] . '</td><td>' . $row['author'] . '</td><td>' . $row['year'] . '</td><td>' . $row['genre'] . '</td><td>' . $row['isbn'] . '</td><td>';
						}
						?>
				</table>
			</div>
		</div>
	</div>
    <footer class="footer">
      <div class="container">
        <p class="text-muted"><br/><br/><br/><br/></p>
      </div>
    </footer>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</body>
</html>
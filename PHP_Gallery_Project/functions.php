<?php
function pdo_connect_mysql() {
    
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'phpgallery';
    try {
        // Verbinden mit der Datenbank
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// Datenbank Verbindung Error Nachtricht.
    	exit('Verbindung fehlgeschlagen');
    }
}

// header
function template_header($title) {
echo <<< EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>Gallery System</h1>
            <a href="index.php"><i class="fas fa-image"></i>Gallery</a>
    	</div>
    </nav>
EOT;
}

// footer
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>
<?php
include 'functions.php';
// Output Nachricht.
$msg = '';
// Überprüfen ob der User ein neues Bild hochgeladen hat.
if (isset($_FILES['image'], $_POST['title'], $_POST['description'])) {
	// Ordner wo die Bilder hochgeladen werden.
	$target_dir = 'images/';
	// Weg des neuen hochgeladenen Bildes.
	$image_path = $target_dir . basename($_FILES['image']['name']);
	// Überprüfen ob das Bild gültig ist.
	if (!empty($_FILES['image']['tmp_name']) && getimagesize($_FILES['image']['tmp_name'])) {
		if (file_exists($image_path)) {
			$msg = 'Bild existiert bereits, bitte wählen Sie ';
		} else if ($_FILES['image']['size'] > 500000) {
			$msg = 'Bilddatei zu gross, bitte wählen Sie ein Bild kleiner als 500kb.';
		} else {
			// Bild wird hochgeladen
			move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
			// Verbindung zu MySQL
			$pdo = pdo_connect_mysql();
			// Bild wird in die Datenbank hochgeladen.
			$stmt = $pdo->prepare('INSERT INTO images (title, description, filepath, uploaded_date) VALUES (?, ?, ?, CURRENT_TIMESTAMP)');
	        $stmt->execute([ $_POST['title'], $_POST['description'], $image_path ]);
			$msg = 'Bild wurde erfolgrich hochgeladen!';
		}
	} else {
		$msg = 'Bitte laden Sie ein Bild hoch!';
	}
}
?>

<?=template_header('Bild hochladen')?>

<div class="content upload">
	<h2>Upload Image</h2>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<label for="image">Bild Auswählen</label>
		<input type="file" name="image" accept="image/*" id="image">
		<label for="title">Titel</label>
		<input type="text" name="title" id="title">
		<label for="description">Beschreibung</label>
		<textarea name="description" id="description"></textarea>
	    <input type="submit" value="Upload Image" name="submit">
	</form>
	<p><?=$msg?></p>
</div>

<?=template_footer()?>
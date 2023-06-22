<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Überprüft ob die Bild Id existiert.
if (isset($_GET['id'])) {
    
    // Auswahl des Bildes zum löschen
    $stmt = $pdo->prepare('SELECT * FROM images WHERE id = ?');
    $stmt->execute([ $_GET['id'] ]);
    $image = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$image) {
        exit('Es exisitert kein Bild mit dieser ID');
    }
    // bestätigen des löschen
    if (isset($_GET['bestätigen'])) {
        if ($_GET['bestätigen'] == 'yes') {
            // Der User klickt den Yes button für das Löschen
            unlink($image['filepath']);
            $stmt = $pdo->prepare('DELETE FROM images WHERE id = ?');
            $stmt->execute([ $_GET['id'] ]);
            // Nachricht nach dem löschen
            $msg = 'Sie haben das Bild gelöscht!';
        } else {
            // Der User klickt den Nein Button und wird zurück auf die Index Seite verwiesen.
            header('Location: index.php');
            exit;
        }
    }
} else {
    exit('Keine ID spezifiziert');
}
?>

<?=template_header('Delete')?>

<div class="content delete">
	<h2>Bild löschen #<?=$image['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Sind Sie sicher Sie wollen das Bild löschen <?=$image['title']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$image['id']?>&confirm=yes">Yes</a>
        <a href="delete.php?id=<?=$image['id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
<?php 	
	
	include("../../ressources/framework/login.inc.php");
	
	require "../../ressources/components/tags.php";	
	require "../../ressources/framework/controler.inc.php";
	require "../../ressources/link.inc.php";	
	
	$controler = new NodeControler(LinkModel::getInstance());	
		
	$controler->doPost($_POST);
	$controler->doGet($_GET);	
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Bibliotheken der Regio Bodensee: Bearbeitung von Links</title>
	</head>
	<body>
		<div class="container">
			<?php foreach ($controler->breadcrumbs as $breadcrumb)  { ?>
				<a href="liste.php?id=<?php echo $breadcrumb['id'] ?>"><?php echo $breadcrumb['titel'] ?></a>
			<?php } ?>
			<div>
				<p><b>Titel: </b><?php echo $controler->record['titel']; ?></p>
				<?php if ($controler->record['beschreibung'] != null && $controler->record['beschreibung'] != '') { ?>
					<p><b>Beschreibung: </b><?php echo $controler->record['beschreibung']; ?></p>
				<?php } ?>
				<?php if ($controler->record['type'] = 1 && $controler->record['url'] != null && $controler->record['url'] != '') { ?>
					<p><b>Url: </b><?php echo $controler->record['url']; ?></p>
				<?php } ?>
			</div>
			<p><a href="formular.php?id=<?php echo $controler->record['id']; ?>&parent=<?php echo $controler->record['parent']; ?>&type=<?php echo $controler->record['type']; ?>">Bearbeiten</a></p>
			<?php if ($controler->record['type'] == 0) { ?>
				<?php if ($controler->reccount > 0) { ?>
					<h3>Einträge</h3>
					<ul>
						<?php foreach($controler->records as $child) {
							echo "<li><a href=\"liste.php?id={$child['id']}\">{$child['titel']}</a></li>"; 
						} ?>
					</ul>
				<?php } ?>
				<p><a href="formular.php?parent=<?php echo $record['id']; ?>&type=0&pos=<?php echo $nextpos; ?>">Neues Verzeichnis</a></p>
				<p><a href="formular.php?parent=<?php echo $record['id']; ?>&type=1&pos=<?php echo $nextpos; ?>">Neuer Link</a></p>
			<?php } ?>
		</div>		
	</body>
</html>

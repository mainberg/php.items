<?php

	require "ressources/bibliothek.controler.inc.php";
	
	$controler = new BibliothekControler();	
		
	$controler->doGet($_GET);
	
	$land = '';
	$ort = '';
			
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="style/euregio.css" media="screen">
		<title>Bibliotheken der Regio Bodensee</title>
	</head>
	<body>
	
		<?php include("ressources/components/head.inc.php"); ?> 
		
		<div id="container1">     
			
			<?php include("ressources/components/left.inc.php"); ?>

			<div id="logo"></div>
			
			<div id="content1">
			
				<div id="spalte1">
					<table>
						<?php foreach ($controler->bibliotheken as $bibliothek) { 
						if ($land != $bibliothek['land']) { ?>
							<tr><td colspan="2"><?php echo BibliothekModel::$laender[$bibliothek['land']]; ?></td></tr>
						<?php $land = $bibliothek['land']; } ?>						
						<tr>
							<td>
							<?php if ($ort != $bibliothek['ort']) {
								echo $bibliothek['ort'];
								$ort = $bibliothek['ort']; } ?>
							</td>
							<td style="padding: 5px;">
								<a href="bibliothek.php?id=<?php echo $bibliothek['id'] ?>"><?php echo $bibliothek['name'] ?></a>
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>
		</div>
	</body>
</html>

<?php
if (!isset($_GET['mod']) || empty($_GET['mod']) || !file_exists("modules/".$_GET['mod']."/module.ini")) {
	?>
	<html><body><h1>Error! Wrong mod parameter passed to this page.</h1></body></html>
	<?php
	exit();
}
$mod_details = parse_ini_file("modules/".$_GET['mod']."/module.ini");
?>
<html>
<head>
	<title>Statistics on IDEM metadata - <?=$mod_details["description"]?></title>

	<script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
	<script type="text/javascript" src="//www.google.com/jsapi"></script>
        <script type="text/javascript" src="resources/shCore.js"></script>
        <script type="text/javascript" src="resources/shBrushXml.js"></script>
        <script type="text/javascript" src="resources/script.js"></script>
	<script type="text/javascript" src="modules/<?=$_GET['mod']?>/module.js"></script>

	<link type="text/css" rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
        <link type="text/css" rel="stylesheet" href="resources/shCoreDefault.css"/>
	<style>
		body { font-family: Helvetica, Verdana, sans-serif; }
		a { text-decoration: none; color: #696969; }
		a:hover { text-decoration: underline; }
		a:visited { color: #696969; }
		#<?= $mod_details["name"] ?>_graph { width: 400px; height: 500px; float: left; }
		#<?= $mod_details["name"] ?>_details { height: 500px; width: auto; overflow: auto; }
		#entityframe { height: 420px; width: 100%; border: 1px solid red; overflow: hidden; border: 0px; }
		.entitylist { display: block; }
		.highlight { background-color: lightgrey; }
	</style>
	<?php
	switch ($mod_details["type"]) {
		case 'pie':
			?>
			<script type="text/javascript">
			google.load("visualization", "1", {packages:["corechart"]});
			google.setOnLoadCallback(draw_<?= $mod_details["name"] ?>);
			</script>
			<?php
			break;
	}
	?>
</head>
<body>
	<?php
	switch ($mod_details["type"]) {
		case 'pie':
			?>
			<h1><?= $mod_details["description"] ?></h1>
			<h3><a href="index.php">IDEM Statistics</a> | <a href="#">Module <?= $mod_details["name"] ?></a></h3>
			<hr/>		
			<div id="<?= $mod_details["name"] ?>_graph"></div>
			<div id="<?= $mod_details["name"] ?>_details"></div>
			</tr></table>
			<hr/>
			<pre id="entityframe"></pre>
			<?php
			break;
	}
	?>
</body>
</html>

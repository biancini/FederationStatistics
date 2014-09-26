<?php
$mod_details = parse_ini_file("module.ini");
?>
<html>
<head>
	<title>Statistics on IDEM metadata - $mod_details["description"]</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
	<script src="module.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="../../shCore.js"></script>
        <script type="text/javascript" src="../../shBrushXml.js"></script>
        <link type="text/css" rel="stylesheet" href="../../shCoreDefault.css"/>
	<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(draw_<?= $mod_details["name"] ?>);
	</script>
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
</head>
<body>
	<h1><?= $mod_details["description"] ?></h1>
	<h3><a href="../../">IDEM Statistics</a> | <a href="#">Module <?= $mod_details["name"] ?></a></h3>
	<hr/>
	<div id="<?= $mod_details["name"] ?>_graph"></div>
	<div id="<?= $mod_details["name"] ?>_details"></div>
	</tr></table>
	<hr/>
	<pre id="entityframe"></pre>

</body>
</html>

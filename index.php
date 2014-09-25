<?php
$modules = scandir("modules");
for ($i = 0; $i < count($modules); ++$i) {
	if ($modules[$i] == '.' || $modules[$i] == '..') {
		unset($modules[$i]);
	}
}
?>
<html>
<head>
	<title>Statistics on IDEM metadata</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<!--
	Attribute count
	 - request some
	 - how many are requested
	 - most requested attributes
	Languages supported
	Contact Information
	Organization information
	Logo images
	SP - init request initiator init:RequestInitiator
	-->

	<div>
		<h2>IDEM metadata statistics</h2>
		<ul>
			<?php
			foreach ($modules as $module) {
				$mod_details = parse_ini_file("modules/" . $module . "/module.ini");
				?>
				<li><a href="modules/<?= $module ?>"><?= $mod_details["description"] ?></a></li>
				<?php
			}
			?>
		</ul>
	</div>

</body>
</html>

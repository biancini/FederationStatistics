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
	<link type="text/css" rel="stylesheet" href="resources/style.css">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="resources/script.js"></script>
	<script type="text/javascript">
		$(function() {
			<?php
			foreach ($modules as $module) {
				print "updateMarker('". $module . "');";
			}
			?>
		});
	</script>
</head>
<body>
	<!--
	Attribute count
	 - request some
	 - how many are requested
	 - most requested attributes
	Contact Information
	Organization information
	-->

	<div>
		<h2>IDEM metadata statistics</h2>
		<ul>
			<?php
			foreach ($modules as $module) {
				$mod_details = parse_ini_file("modules/" . $module . "/module.ini");
				?>
				<li>
					<a href="module.php?mod=<?= $module ?>"><?= $mod_details["description"] ?>
					<span id="<?= $module ?>_marker" class="marker"></a>
				</li>
				<?php
			}
			?>
		</ul>
	</div>

</body>
</html>

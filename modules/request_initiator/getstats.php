<?php

include('../../functions.php');

function getStats() {
	$entities = _getEntities("SP");

	$output = array(
		"count" => 0,
		"ok" => array(),
		"ko" => array(),
	);

	foreach($entities as $entity) {
		$curentity = array();
		$curentity["id"] = _stringSanitize((string) $entity["entityID"]);
		$curentity["name"] = _getEntityName($entity);

		if (count($entity->xpath(".//init:RequestInitiator")) > 0) {
			$output["ok"][] = $curentity;
		} else {
			$output["ko"][] = $curentity;
		}
		$output["count"]++;
	}

	usort($output["ok"], "_sortEntitites");
	usort($output["ko"], "_sortEntitites");
	return $output;
}

function getMarker() {
	$green = .9;
	$amber = .8;
	
	$stats = getStats();
	$ratio = count($stats["ok"]) / $stats["count"];

	if ($ratio >= $green) {
		return "green";
	} elseif ($ratio >= $amber) {
		return "amber";
	} else {
		return "red";
	}
}

header("Content-Type: application/json");

if ($_GET["view"] == "marker") {
	$output = getMarker();
} else {
	$output = getStats();
}

print json_encode($output);

?>

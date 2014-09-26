<?php

include('../../functions.php');

function getStats() {
	$entities = _getEntities("ALL");

	$output = array(
		"count" => 0,
		"zero" => array(),
		"only_it" => array(),
		"only_en" => array(),
		"ok" => array(),
	);

	foreach($entities as $entity) {
		$curentity = array();
		$curentity["id"] = _stringSanitize((string) $entity["entityID"]);
		$curentity["name"] = _getEntityName($entity);

		if (count($entity->xpath(".//mdui:PrivacyStatementURL[@xml:lang='en']")) > 0 &&
		    count($entity->xpath(".//mdui:PrivacyStatementURL[@xml:lang='it']")) > 0) {
			$output["ok"][] = $curentity;
		} elseif (count($entity->xpath(".//mdui:PrivacyStatementURL[@xml:lang='en']")) > 0) {
			$output["only_en"][] = $curentity;
		} elseif (count($entity->xpath(".//mdui:PrivacyStatementURL[@xml:lang='it']")) > 0) {
			$output["only_it"][] = $curentity;
		} else {
			$output["zero"][] = $curentity;
		}
		$output["count"]++;
	}

	usort($output["zero"], "_sortEntitites");
	usort($output["only_it"], "_sortEntitites");
	usort($output["only_en"], "_sortEntitites");
	usort($output["ok"], "_sortEntitites");
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

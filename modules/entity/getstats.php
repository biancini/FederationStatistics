<?php

include('../../functions.php');

function getStats() {
	$entities = _getEntities("ALL");

	$output = array(
		"count" => 0,
		"idps" => array(),
		"sps" => array(),
	);

	foreach($entities as $entity) {
		$curentity = array();
		$curentity["id"] = _stringSanitize((string) $entity["entityID"]);
		$curentity["name"] = _getEntityName($entity);

		if (count($entity->xpath(".//md:IDPSSODescriptor")) > 0) {
			$output["idps"][] = $curentity;
		} elseif (count($entity->xpath(".//md:SPSSODescriptor")) > 0) {
			$output["sps"][] = $curentity;
		}
		$output["count"]++;
	}

	usort($output["idps"], "_sortEntitites");
	usort($output["sps"], "_sortEntitites");
	return $output;
}

function getMarker() {
	return "";
}

header("Content-Type: application/json");

if ($_GET["view"] == "marker") {
	$output = getMarker();
} else {
	$output = getStats();
}

print json_encode($output");

?>

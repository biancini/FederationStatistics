<?php

include('../../functions.php');

function getStats() {
	$entities = _getEntities("IDP");

	$output = array(
		"count" => 0,
		"ok" => array(),
		"miss_lang" => array(),
		"miss_size" => array(),
		"ko" => array(),
	);

	foreach($entities as $entity) {
		$curentity = array();
		$curentity["id"] = _stringSanitize((string) $entity["entityID"]);
		$curentity["name"] = _getEntityName($entity);

		$lang_en = "[@xml:lang='en']";
		$lang_it = "[@xml:lang='it']";
		$size_16 = "[@height='16'][@width='16']";
		$size_80 = "[@height='80'][@width='80']";

		if (count($entity->xpath(".//mdui:Logo" . $lang_en . $size16)) > 0 &&
		    count($entity->xpath(".//mdui:Logo" . $lang_en . $size80)) > 0 &&
		    count($entity->xpath(".//mdui:Logo" . $lang_it . $size16)) > 0 &&
		    count($entity->xpath(".//mdui:Logo" . $lang_it . $size80)) > 0) {
			$output["ok"][] = $curentity;
		} elseif ((count($entity->xpath(".//mdui:Logo" . $lang_en . $size16)) > 0 &&
		           count($entity->xpath(".//mdui:Logo" . $lang_en . $size80)) > 0) ||
		          (count($entity->xpath(".//mdui:Logo" . $lang_it . $size16)) > 0 &&
		           count($entity->xpath(".//mdui:Logo" . $lang_it . $size80)) > 0)) {
			$output["miss_lang"][] = $curentity;
		} elseif ((count($entity->xpath(".//mdui:Logo" . $lang_en . $size16)) > 0 &&
		           count($entity->xpath(".//mdui:Logo" . $lang_it . $size16)) > 0) ||
		          (count($entity->xpath(".//mdui:Logo" . $lang_en . $size80)) > 0 &&
		           count($entity->xpath(".//mdui:Logo" . $lang_it . $size80)) > 0)) {
			$output["miss_size"][] = $curentity;
		} else {
			$output["ko"][] = $curentity;
		}
		$output["count"]++;
	}

	usort($output["ok"], "_sortEntitites");
	usort($output["miss_lang"], "_sortEntitites");
	usort($output["miss_size"], "_sortEntitites");
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

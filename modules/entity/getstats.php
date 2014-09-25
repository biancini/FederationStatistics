<?php

include('../../getstats.php');

function getStats() {
	global $metadata_url;
	$feed = file_get_contents($metadata_url);
	$xml = new SimpleXmlElement($feed);
	$entities = $xml->xpath("//md:EntityDescriptor");

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
	print json_encode($output);
}

header("Content-Type: application/json");
getStats();

?>

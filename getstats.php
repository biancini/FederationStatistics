<?php

$metadata_url = "http://www.garr.it/idem-metadata/idem-metadata-sha256.xml";

function _stringSanitize($instring) {
	return $instring;
}

function _sortEntitites($a, $b) {
	return strcmp((string) $a["name"], (string) $b["name"]);
}

function _getEntityName($entity) {
	$xpath_search = array(".//mdui:DisplayName[@xml:lang='it']", ".//mdui:DisplayName[@xml:lang='en']",
	                      ".//md:OrganizationDisplayName[@xml:lang='it']", ".//md:OrganizationDisplayName[@xml:lang='en']");

	foreach ($xpath_search as $curxpath) {
		if (count($entity->xpath($curxpath)) > 0) {
			$name = $entity->xpath($curxpath);
			return (string) $name[0];
		}
	}

	return NULL;
}

?>

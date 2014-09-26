<?php

$metadata_url = "http://www.garr.it/idem-metadata/idem-metadata-sha256.xml";

function _getEntities($filter = "ALL") {
	global $metadata_url;
        $feed = file_get_contents($metadata_url);
        $xml = new SimpleXmlElement($feed);
        $all_entities = $xml->xpath("//md:EntityDescriptor");
	$filtered_entities = array();

	foreach ($all_entities as $entity) {
		if ($filter == "IDP") {
			if (count($entity->xpath(".//md:IDPSSODescriptor")) > 0) {
				$filtered_entities[] = $entity;
			}
		} elseif ($filter == "SP") {
			if (count($entity->xpath(".//md:SPSSODescriptor")) > 0) {
				$filtered_entities[] = $entity;
			}
		} else {
			$filtered_entities[] = $entity;
		}
	}

	return $filtered_entities;
}

function _stringSanitize($instring) {
	return ltrim(trim($instring));
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

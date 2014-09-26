<?php
include('getstats.php');

global $metadata_url;

$feed = file_get_contents($metadata_url);
$xml = new SimpleXmlElement($feed);
$entities = $xml->xpath("//md:EntityDescriptor");

$entityid = $_GET["id"];

foreach($entities as $entity) {
	if ((string) $entity["entityID"] == $entityid) {
		print $entity->asXML();
	}
}
?>

<?php
include('getstats.php');

global $metadata_url;

$feed = file_get_contents($metadata_url);
$xml = new SimpleXmlElement($feed);
$entities = $xml->xpath("//md:EntityDescriptor");

$entityid = $_GET["id"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script type="text/javascript" src="shCore.js"></script>
        <script type="text/javascript" src="shBrushXml.js"></script>
        <link type="text/css" rel="stylesheet" href="shCoreDefault.css"/>
        <script type="text/javascript">SyntaxHighlighter.all();</script>
</head>

<body style="background: white; font-family: Helvetica; font-size: 10pt">
<pre class="brush: xml;">
<?php
foreach($entities as $entity) {
	if ((string) $entity["entityID"] == $entityid) {
		print $entity->asXML();
	}
}
?>
</pre>

</html>

<?php

// BUGS: Used $entry->dataUrl (original uploaded video) because $entry->downloadUrl doesn't work 
// for the default samples in the SaaS accounts.....!
// Where are the downloadUrls for the default samples in the account?

// Your Kaltura partner credentials
define("PARTNER_ID", "nnnnnn");
define("ADMIN_SECRET", "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx");
define("USER_SECRET",  "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx");

require_once "KalturaClient.php";

// List all videos in your KMC

$user = "SomeoneWeKnow"; 
$kconf = new KalturaConfiguration(PARTNER_ID);
$kclient = new KalturaClient($kconf);
$ksession = $kclient->session->start(ADMIN_SECRET, $user, KalturaSessionType::ADMIN);

if (!isset($ksession)) {
	die("Could not establish Kaltura session. Please verify that you are using valid Kaltura partner credentials.");
}

$kclient->setKs($ksession);

// Set the response format
// KALTURA_SERVICE_FORMAT_JSON  json
// KALTURA_SERVICE_FORMAT_XML   xml
// KALTURA_SERVICE_FORMAT_PHP   php
$kconf->format = KalturaClientBase::KALTURA_SERVICE_FORMAT_PHP;

$kfilter = new KalturaMediaEntryFilter();
$kfilter->mediaTypeEqual = KalturaMediaType::VIDEO;

$result = $kclient->media->listAction($kfilter);

echo "<h1>My Videos</h1>";
echo "<table>";
foreach ($result->objects as $entry) {
	echo '<tr><td><img src="'.$entry->thumbnailUrl.'">&nbsp;&nbsp;
    Title: '.$entry->name.'&nbsp;&nbsp;
     <a href="'.$entry->dataUrl.'">download</a>&nbsp;&nbsp;
     Created on: '.date("D M j G:i:s T Y", $entry->createdAt).'</td></tr>';
}
echo "</table>";

?>
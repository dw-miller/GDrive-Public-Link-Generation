<?php

require ('init.php');
// Get the API client and send service request

$KeyWord = 'Scre';

$client = getClient();
$service = new Google_Service_Drive($client);
$links = fopen("links.txt", "w") or die("File error!");

$pageToken = null;
do {
  $response = $service->files->listFiles(array(
    'q' => "name contains '$KeyWord'",
    'spaces' => 'drive',
    'pageToken' => $pageToken,
    'fields' => 'nextPageToken, files(id, name)',
  ));
  printf("Generating public links...\n");
  foreach ($response->files as $file) {
      printf("Filename: %s   ID: (%s)\n", $file->name, $file->id);
	  $link = "https://drive.google.com/uc?export=view&id=".$file->id.PHP_EOL;
	  
	  fwrite($links, $link);
	  //fwrite($links,"    \r\n");
	  
  }
} while ($pageToken != null);

fclose($links);



?>
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';



$hashtags = "
#NYCblogger
#Torontobeautyblogger
#bbloggersca
#Torontofashionblogger
#torontofashionbloggers
#torontoblogger
#miamiblogger
#chicagoblogger
#houstonblogger
#midwestblogger
#LAblogger
#toronto
#newyork
#newyorkcity
#canada
#beauty
#blog
#unitedstates
#fashionista
#fashion
#style
#blogger
#youtube
#brasil
#bloggers
#bloggerlife
#blogs
#fashionblogger
#nyc
#ny
#newyorker
#newyorkcity
#Travelblogger
#wearetravelgirls
#Darlingescapes
#dametraveler
#foodblogger
#foodbloggers
#foodblog
#atxblogger
#atxfoodblogs
#fashionblogger
#beautyblogger
#lifestyleblogger
#lifestyleblog
#blogger
#bloggerlife
#blogpost
#blogging
#bloggerstyle
#instablogger
#instabloggers
#blog
#yycblogger
#Canadianblogger
#Vancouverblogger
#yvrblogger
#dallasblogger
";

$hashtags = explode('#', $hashtags);
foreach ($hashtags as $x => $value) {
    $hashtags[$x] = trim($value);
}
unset($hashtags[0]);


$index =file_get_contents("index.txt");
$index = intval($index);

if($index == count($hashtags))
{
    $index = 1;
}

$hashtag = $hashtags[$index];

$new_index = $index+1;
file_put_contents('index.txt',$new_index);


// foreach ($hashtags as $hashtag) {
	
	$media = Bolandish\Instagram::getMediaByHashtag($hashtag, 200 , false, true);
	// printme($media);
	// exit();
	include_once('instagram_script.php');
	exit();
// }

// printme($hashtags);
exit();


//Its getting 10 images/videoes from instagram with the hastag #nofilter
$media = Bolandish\Instagram::getMediaByHashtag("nyc", 1 , false, true);


foreach ($media as $post) {
	$owner_id = $post->owner->id;
	$user_media = Bolandish\Instagram::getMediaByUserID($owner_id,100);
}

printme($media);
printme($user_media);

exit();


function printme($x)
{
	echo '<pre>'.print_r($x,true).'</pre>';
}
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
#love
#instagood
#me
#tbt
#cute
#follow
#followme
#photooftheday
#happy
#tagforlikes
#beautiful
#self
#girl
#picoftheday
#like4like
#smile
#friends
#fun
#like
#fashion
#summer
#instadaily
#igers
#instalike
#food
#swag
#amazing
#tflers
#follow4follow
#bestoftheday
#likeforlike
#instamood
#style
#wcw
#family
#141
#f4f
#nofilter
#lol
#life
#pretty
#repost
#hair
#my
#sun
#webstagram
#iphoneonly
#art
#tweegram
#cool
#followback
#instafollow
#instasize
#bored
#instacool
#funny
#mcm
#instago
#instasize
#vscocam
#girls
#all_shots
#party
#music
#eyes
#nature
#beauty
#night
#fitness
#beach
#look
#nice
#sky
#christmas
#baby
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
	printme($media);
	exit();
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
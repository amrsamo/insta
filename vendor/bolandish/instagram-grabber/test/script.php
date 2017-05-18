<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';



$hashtags = "
#losangelesblogger
#montrealblogger
#sfblogger
#sanfranciscoblogger
#sfblogger
#washingtonblogger
#bostonblogger
#seattleblogger
#phillyblogger
#sandiegoblogger
#detroitblogger
#atlantablogger
#dallasblogger
#phoenixblogger
#calgaryblogger
#denverblogger
#Pittsburghblogger
#bloglovin
#dcblogger
#dslr
#labeautyblogger
#lafashionblogger
#lastyleblogger
#thebloggerunion
#liketoknowit
#sitsblogging
#bloggerbabes
#giftguide
#malestyle
#bloggerswanted
#blogilates
#blogto
#bloggerdiaries
#bloggervibes
#bloggingtips
#londonblogger
#londonbloggers
#ukblogger
#ukbloggers
#britishblogger
#britishbloggers
#muanyc
#nycfitness
#fitnessblogger
#foodbloggerlife
#torontofashion
#nycfashion
#londonfashion
#birminghamblogger
#bristolbloggers
#glasgowblogger
#glasgowbloggers
#manchesterblogger
#edinburghbloggers
#liverpoolbloggers
#leedsbloggers
#leedsblogger
#cardiffblogger
#newcastleblogger
#voxfordblogger
#nottinghamblogger
#southamptonblogger
#englishblogger
#britishstyle
#irishblogger
#irishbloggers
#dublinblogger
#belfastblogger
#irishblog
#ukblog
#ukfoodblogger
#ukfitnessblogger
#ukfitnessblog 
#ukyoga
#vscoireland
#vscouk
#vscocanada
#vscousa
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
	// printme($hashtag);
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
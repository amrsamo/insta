<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

//Its getting 10 images/videoes from instagram with the hastag #nofilter
$media = Bolandish\Instagram::getMediaByHashtag("nyc", 1 , false, true);


foreach ($media as $post) {
	$owner_id = $post->owner->id;
	$user_media = Bolandish\Instagram::getMediaByUserID($owner_id,100);
}

printme($media);
printme($user_media);

exit();

//Its getting 10 images/videoes from Selena Gomezs instagram.. mmhh..
$media = Bolandish\Instagram::getMediaByUserID(460563723, 10);

//Get 10 images/videos after the media with the id 1060728019300790746 from Selena Gomex
$media = Bolandish\Instagram::getMediaAfterByUserID(460563723,1060728019300790746, 10);

//Its getting 10 last comments under Selena Gomezs photo
$media = Bolandish\Instagram::getCommentsByMediaShortcode("BGQh8XmOjLM", 10); 

//Get 10 comments before the comment with the id 17862588298017953 under Selena Gomezs photo
$media = Bolandish\Instagram::getCommentsBeforeByMediaShortcode("BGQh8XmOjLM", 17862588298017953, 10); 
//Display square images only
$media = Bolandish\Instagram::getMediaByHashtag("wildlife", 20);
foreach($media as $value){
  if ($value->dimensions->width === $value->dimensions->height){
    echo '<img src="' .$value->display_src. '" alt="' .$value->caption. '" />';
  }
}
//Make images clickable and link to instagram post
foreach($media as $key=>$value){
  if ($value->dimensions->width === $value->dimensions->height){
		echo '<a href="'.'https://www.instagram.com/p/'.$media[$key]->code.'" target="_blank"><img src="'.$media[$key]->display_src.'" alt="'.$media[$key]->caption.'" /></a>';
  }
}


function printme($x)
{
	echo '<pre>'.print_r($x,true).'</pre>';
}
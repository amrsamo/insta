<?php

ini_set('max_execution_time', 3000);
 
    // printme('<h2>Loop number '.$count.'</h2>');
    foreach ($media as $photo) {

        // printme($photo);

        $owner_account = $photo->owner;
        $user_data = array();
        $user_data['username'] = $owner_account->username;
        $user_data['url'] = 'https://www.instagram.com/'.$owner_account->username.'/';
        $user_data['followers'] = $owner_account->followed_by->count;
        $user_data['hashtag']       = $hashtag;
        $user_data['externalUrl']       = $owner_account->external_url;
        $user_data['instagram_unique_id']       = $owner_account->id;
        $user_data['fullName']       = $owner_account->full_name;
        $user_data['profilePicUrl']       = $owner_account->profile_pic_url;
        $user_data['biography']       = $owner_account->biography;
        $user_data['followsCount']       = $owner_account->follows->count;
        $user_data['mediaCount']       = $owner_account->media->count;
        // $user_data['isPrivate']       = $owner_account->isPrivate;
        // $user_data['isVerified']       = $owner_account->isVerified;

        // printme($user_data);
        // exit();
        saveMails(getMails($owner_account->biography),$user_data);
        
    }
    

 

function getMails($string)
{   
    $mails = array();
    $pattern = '/[A-Za-z0-9_-]+@[A-Za-z0-9_-]+\.([A-Za-z0-9_-][A-Za-z0-9_]+)/';
    preg_match_all($pattern, $string, $matches);
    $matches = $matches[0];
    if(is_array($matches))
    {
        foreach ($matches as $match) {
            $mails[] = $match;
        }
    }

    return $mails;
}

function saveMails($data, $user_data)
{

    if(empty($data))
    {
        $data = array();
        $data[] = 'na_'.$user_data['instagram_unique_id'];
    }
    

    // $servername = "localhost";
    // $username = "root";
    // $password = "root";
    // $dbname = "insta_mails";
    $HTTP_HOST = $_SERVER['HTTP_HOST'];

    if($HTTP_HOST == 'localhost')
    {
        //Development
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "insta_mails";
    }
    else
    {
        //Production
        $servername = "localhost";
        $username = "root";
        $password = ".?R](%B=<NE,6'g";
        $dbname = "insta_mails";
    }

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }


    
    
    if($user_data['isPrivate'])
        $isPrivate = 1;
    else
        $isPrivate = 0;

    if($user_data['isVerified'])
        $isVerified = 1;
    else
        $isVerified = 0;

    foreach ($data as $mail) {
        $sql = "INSERT INTO mails_scrap (email,username,url,followers,hashtag, externalUrl, location,instagram_unique_id,fullName,profilePicUrl ,biography,followsCount,mediaCount,isPrivate,isVerified,country,city)
                VALUES ('".$mail."','".$user_data['username'].
                           "','".$user_data['url'].
                           "',".$user_data['followers'].",
                           '".$user_data['hashtag']."',
                           '".$user_data['externalUrl']."',
                           '".$user_data['location']."',
                           '".$user_data['instagram_unique_id']."',
                           '".$user_data['fullName']."',
                           '".$user_data['profilePicUrl']."',
                           '".$user_data['biography']."',
                           '".$user_data['followsCount']."',
                           '".$user_data['mediaCount']."',
                           '".$isPrivate."',
                           '".$isVerified."',
                           '".$user_data['country']."',
                           '".$user_data['city']."'


                        )";


        if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    $conn->close();
}


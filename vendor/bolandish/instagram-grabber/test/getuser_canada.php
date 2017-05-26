<?php 


error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

getUsers();
exit();
$media = Bolandish\Instagram::getAccount(1970202315);

printme($media);




function getUsers()
{
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

    $conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT user_id FROM canada_followers limit 1000";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) 
	{
	    // output data of each row
	    while($row = $result->fetch_assoc()) 
	    {
	        $user_id = $row['user_id'];
	        $media = Bolandish\Instagram::getAccount($user_id);

	        $owner_account = $media;
	        $user_data = array();
	        $user_data['username'] = $owner_account->username;
	        $user_data['url'] = 'https://www.instagram.com/'.$owner_account->username.'/';
	        $user_data['followers'] = $owner_account->followed_by->count;
	        $user_data['hashtag']       = 'australia';
	        $user_data['externalUrl']       = $owner_account->external_url;
	        $user_data['instagram_unique_id']       = $owner_account->id;
	        $user_data['fullName']       = $owner_account->full_name;
	        $user_data['profilePicUrl']       = $owner_account->profile_pic_url;
	        $user_data['biography']       = $owner_account->biography;
	        $user_data['followsCount']       = $owner_account->follows->count;
	        $user_data['mediaCount']       = $owner_account->media->count;

        
        	saveMails(getMails($owner_account->biography),$user_data);
        	deleteUser($user_id);
		}
	} 
	else 
	{
	    echo "0 results";
	}

	$conn->close();
	
}

function deleteUser($id)
{

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

	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	// sql to delete a record
	$sql = "DELETE FROM canada_followers WHERE user_id='".$id."'";

	if ($conn->query($sql) === TRUE) {
	    echo "Record deleted successfully";
	} else {
	    echo "Error deleting record: " . $conn->error;
	}

	$conn->close();
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


    
    
        $isPrivate = 0;
        $isVerified = 0;
        $user_data['location'] = '';
        $user_data['country'] = '';
        $user_data['city'] = '';


        foreach ($data as $mail) {
            
        
            $sql = 'INSERT INTO mails_scrap_2 (email,username,url,followers,hashtag, externalUrl, location,instagram_unique_id,fullName,profilePicUrl ,biography,followsCount,mediaCount,isPrivate,isVerified,country,city)
                    VALUES (
                        "'.$mail.'",
                        "'.$user_data['username'].'",
                        "'.$user_data['url'].'",
                        "'.$user_data['followers'].'",
                        "'.$user_data['hashtag'].'",
                        "'.$user_data['externalUrl'].'",
                        "'.$user_data['location'].'",
                        "'.$user_data['instagram_unique_id'].'",
                        "'.$user_data['fullName'].'",
                        "'.$user_data['profilePicUrl'].'",
                        "'.$user_data['biography'].'",
                        "'.$user_data['followsCount'].'",
                        "'.$user_data['mediaCount'].'",
                        "'.$isPrivate.'",
                        "'.$isVerified.'",
                        "'.$user_data['country'].'",
                        "'.$user_data['city'].'"
                        )';


            if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

    $conn->close();
}



function printme($x)
{
	echo '<pre>'.print_r($x,true).'</pre>';
}
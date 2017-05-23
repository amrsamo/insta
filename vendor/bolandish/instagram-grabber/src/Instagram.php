<?php
namespace Bolandish;

class Instagram {
    /**
     * @var array
     */
    protected static $curlProxy = array();

    public static function setCurlProxy(array $config) {
        foreach ($config as $k => $v) {
            if ((in_array($k, array(CURLOPT_HTTPPROXYTUNNEL)) && is_bool($v))
                || (in_array($k, array(CURLOPT_PROXYAUTH, CURLOPT_PROXYPORT, CURLOPT_PROXYTYPE)) && is_int($v))
                || (in_array($k, array(CURLOPT_PROXY, CURLOPT_PROXYUSERPWD)) && is_string($v))
            ) {
                self::$curlProxy[$k] = $v;
            }
        }
    }

    const ACCOUNT_JSON_INFO_BY_ID = 'ig_user({userId}){id,username,external_url,full_name,profile_pic_url,biography,followed_by{count},follows{count},media{count},is_private,is_verified}';

    public static function getAccount($id)
    {   
        $assoc = false;
        $parameters = str_replace('{userId}', urlencode($id), 'ig_user({userId}){id,username,external_url,full_name,profile_pic_url,biography,followed_by{count},follows{count},media{count},is_private,is_verified}');
        $user = json_decode(static::getContentsFromUrl($parameters), ($assoc || $assoc == "array"));
        return $user;
    }
    
    protected static function setProxy()
    {
        
    $proxyies = array();
    $proxyies[] = '89.32.69.2:3128';
    $proxyies[] = '192.126.159.29:3128';
    $proxyies[] = '89.32.69.91:3128';
    $proxyies[] = '50.31.8.56:3128';
    $proxyies[] = '50.31.8.21:3128';
    $proxyies[] = '50.31.8.149:3128';
    $proxyies[] = '192.126.159.203:3128';
    $proxyies[] = '89.32.69.87:3128';
    $proxyies[] = '50.31.8.17:3128';
    $proxyies[] = '89.32.69.206:3128';


        //NEW 50 PROXIES
    $proxyies[] = '170.130.62.4:3128';
    $proxyies[] = '206.214.93.65:3128';
    $proxyies[] = '192.126.159.228:3128';
    $proxyies[] = '104.140.210.122:3128';
    $proxyies[] = '206.214.93.250:3128';
    $proxyies[] = '104.140.209.88:3128';
    $proxyies[] = '104.140.210.136:3128';
    $proxyies[] = '206.214.93.46:3128';
    $proxyies[] = '170.130.62.200:3128';
    $proxyies[] = '192.126.159.212:3128';
    $proxyies[] = '104.140.210.98:3128';
    $proxyies[] = '173.234.249.239:3128';
    $proxyies[] = '104.140.209.33:3128';
    $proxyies[] = '104.140.209.62:3128';
    $proxyies[] = '173.234.249.16:3128';
    $proxyies[] = '192.126.157.3:3128';
    $proxyies[] = '104.140.210.161:3128';
    $proxyies[] = '170.130.62.145:3128';
    $proxyies[] = '192.126.159.118:3128';
    $proxyies[] = '192.126.159.246:3128';
    $proxyies[] = '170.130.62.40:3128';
    $proxyies[] = '206.214.93.166:3128';
    $proxyies[] = '206.214.93.69:3128';
    $proxyies[] = '206.214.93.139:3128';
    $proxyies[] = '192.126.157.207:3128';
    $proxyies[] = '192.126.159.45:3128';
    $proxyies[] = '170.130.62.212:3128';
    $proxyies[] = '94.229.71.61:3128';
    $proxyies[] = '192.126.159.253:3128';
    $proxyies[] = '104.140.210.65:3128';
    $proxyies[] = '192.126.157.139:3128';
    $proxyies[] = '94.229.71.67:3128';
    $proxyies[] = '170.130.62.216:3128';
    $proxyies[] = '104.140.210.85:3128';
    $proxyies[] = '192.126.159.200:3128';
    $proxyies[] = '192.126.159.146:3128';
    $proxyies[] = '206.214.93.34:3128';
    $proxyies[] = '94.229.71.28:3128';
    $proxyies[] = '192.126.157.63:3128';
    $proxyies[] = '192.126.157.39:3128';
    $proxyies[] = '192.126.157.124:3128';
    $proxyies[] = '206.214.93.247:3128';
    $proxyies[] = '104.140.209.177:3128';
    $proxyies[] = '192.126.157.8:3128';
    $proxyies[] = '104.140.209.192:3128';
    $proxyies[] = '94.229.71.14:3128';
    $proxyies[] = '94.229.71.42:3128';
    $proxyies[] = '94.229.71.108:3128';
    $proxyies[] = '104.140.209.173:3128';
    $proxyies[] = '192.126.157.47:3128';

        // $proxies = explode(',', $proxies);

        // foreach ($proxies as $x => $value) {
        //     $proxies[$x] = trim($value);
        // }

            $index =file_get_contents("proxy.txt");
            $index = intval($index);

            // $index =9;
            $proxy = $proxyies[$index];
            $new_index = $index+1;
            if($new_index == count($proxyies))
                $new_index = 0;
            file_put_contents('proxy.txt',$new_index);
            
            
            return $proxy;

        }

    protected static function getContentsFromUrl($parameters) {
        if (!function_exists('curl_init')) {
            return false;
        }
        
        $random = self::generateRandomString();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/query/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'q='.$parameters);
        
        $proxy = self::setProxy();
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        // $username = '1543amrsamo';
        // $password = 'bakrbakr';

        // curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        // foreach (self::$curlProxy as $k => $v) {
        //     curl_setopt($ch, $k, $v);
        // }
        $headers = array();
        $headers[] = "Cookie:  csrftoken=$random;";
        $headers[] = "X-Csrftoken: $random";
        $headers[] = "Referer: https://www.instagram.com/";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $output = curl_exec($ch);
        

        if (preg_match("/OK/i", $output)) {
             return $output;
        }
        else
        {
            echo 'here '.$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            print "error:" . curl_error($ch) . "<br />";
            print "output:" . $output . "<br /><br />";
            exit();
        }

        curl_close($ch);

        
    }
    protected static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getMediaByHashtag($hashtag = null, $count = 16, $assoc = false, $comment_count = false ,$max_id = false)
    {
        if ( empty($hashtag) || !is_string($hashtag) )
        {
            return false;
        }
        if($comment_count){
            $comments = "comments.last($comment_count) {           count,           nodes {             id,             created_at,             text,             user {               id,               profile_pic_url,               username             }           },           page_info         }";
        }else{
            $comments = "comments {       count     }";
        }

        $hashtag = strtolower($hashtag);
        
        if($max_id)
        {
            $parameters = urlencode("ig_hashtag($hashtag) { media.after($count,$count) {   count,   nodes {     caption,     code, location,   $comments,     date,     dimensions {       height,       width     },     display_src,     id,     is_video,     likes {       count     },     owner {       id,       username,       full_name,       profile_pic_url,     biography   ,follows{count}  ,followed_by{count} ,media{count} ,external_url     },     thumbnail_src,     video_views,     video_url   },   page_info }  }");
        }
        else
        {
            $parameters = urlencode("ig_hashtag($hashtag) { media.first($count) {   count,   nodes {     caption,     code, location,   $comments,     date,     dimensions {       height,       width     },     display_src,     id,     is_video,     likes {       count     },     owner {       id,       username,       full_name,       profile_pic_url,     biography   ,follows{count}  ,followed_by{count} ,media{count} ,external_url, email    },     thumbnail_src,     video_views,     video_url   },   page_info } ,page_info }");
        }

        $media = json_decode(static::getContentsFromUrl($parameters), ($assoc || $assoc == "array"));
        if($assoc == "array")
            $media = $media["media"]["nodes"];
        elseif (isset($media->media->nodes))
            $media = $media->media->nodes;
        else
            $media = array();
        return $media;
    }

    public static function getMediaByUserID($user = null, $count = 16, $assoc = false, $comment_count = false)
    {
        if ( empty($user) || !(is_string($user) || is_int($user)) )
        {
            return false;
        }
        if($comment_count){
            $comments = "comments.last($comment_count) {           count,           nodes {             id,             created_at,             text,             user {               id,               profile_pic_url,               username             }           },           page_info         }";
        }else{
            $comments = "comments {       count     }";
        }
        $parameters = urlencode("ig_user($user) { media.first($count) {   count,   nodes {     caption,     code,     $comments,     date,     dimensions {       height,       width     },     display_src,     id,     is_video,     likes {       count     },     owner {       id,       username,       full_name,       profile_pic_url,     biography     },     thumbnail_src,     video_views,     video_url , location  },   page_info }  }");
        $media = json_decode(static::getContentsFromUrl($parameters),($assoc || $assoc == "array"));
        if($assoc == "array")
            $media = $media["media"]["nodes"];
        elseif (isset($media->media->nodes))
            $media = $media->media->nodes;
        else
            $media = array();

        return $media;
    }

    public static function getMediaAfterByUserID($user = null, $min_id, $count = 16, $assoc = false, $comment_count = false)
    {
        if ( empty($user) || !(is_string($user) || is_int($user)) )
        {
            return false;
        }
        if($comment_count){
            $comments = "comments.last($comment_count) {           count,           nodes {             id,             created_at,             text,             user {               id,               profile_pic_url,               username             }           },           page_info         }";
        }else{
            $comments = "comments {       count     }";
        }

        $parameters = urlencode("ig_user($user) { media.after($min_id,$count) {   count,   nodes {     caption,     code,    $comments,   date,     dimensions {       height,       width     },     display_src,     id,     is_video,     likes {       count     },     owner {       id,       username,       full_name,       profile_pic_url,     biography     },     thumbnail_src,     video_views,     video_url   },   page_info }  }");

        $media = json_decode(static::getContentsFromUrl($parameters),($assoc || $assoc == "array"));
        if($assoc == "array")
            $media = $media["media"]["nodes"];
        elseif (isset($media->media->nodes))
            $media = $media->media->nodes;
        else
            $media = array();

        return $media;
    }

    public static function getCommentsByMediaShortcode($media_shortcode = null, $count = 16, $assoc = false)
    {

        $comments = "comments.last($count) {           count,           nodes {             id,             created_at,             text,             user {               id,               profile_pic_url,               username             }           },           page_info         }";

        $parameters = urlencode("ig_shortcode({$media_shortcode}) { $comments }");
        $comments = json_decode(static::getContentsFromUrl($parameters),($assoc || $assoc == "array"));
        if($assoc == "array")
            $comments = $comments["comments"]["nodes"];
        elseif (isset($comments->comments->nodes))
            $comments = $comments->comments->nodes;
        else
            $comments = array();
        return $comments;
    }

    public static function getCommentsBeforeByMediaShortcode($media_shortcode = null, $max_id, $count = 16, $assoc = false)
    {

        $comments = "comments.before($max_id, $count) {           count,           nodes {             id,             created_at,             text,             user {               id,               profile_pic_url,               username             }           },           page_info         }";

        $parameters = urlencode("ig_shortcode({$media_shortcode}) { $comments }");
        $comments = json_decode(static::getContentsFromUrl($parameters),($assoc || $assoc == "array"));
        if($assoc == "array")
            $comments = $comments["comments"]["nodes"];
        elseif (isset($comments->comments->nodes))
            $comments = $comments->comments->nodes;
        else
            $comments = array();
        return $comments;
    }
}
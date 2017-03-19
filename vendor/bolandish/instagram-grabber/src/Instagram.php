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
        $proxies = "89.32.69.2:3128,192.126.159.29:3128,89.32.69.91:3128,50.31.8.56:3128,50.31.8.21:3128,50.31.8.149:3128,192.126.159.203:3128,89.32.69.87:3128,50.31.8.17:3128,89.32.69.206:3128,185.152.128.128:10220,185.152.128.9:10205
                    ,185.152.128.116:10196
                    ,185.152.128.70:10186
                    ,185.152.128.51:10463
                    ,185.152.128.59:10350
                    ,185.152.128.68:10179
                    ,185.152.128.77:10205
                    ,185.152.128.10:10248
                    ,185.152.128.41:10465
                    ,185.152.128.69:10179
                    ,185.152.128.120:10223
                    ,185.152.128.42:10461
                    ,185.152.128.14:10211
                    ,185.152.128.112:10036
                    ,185.152.128.17:10221
                    ,185.152.128.64:10436
                    ,185.152.128.40:10442
                    ,185.152.128.22:10412
                    ,185.152.128.33:10427
                    ,185.152.128.71:10187
                    ,185.152.128.53:10389
                    ,185.152.128.47:10388
                    ,185.152.128.76:10207
                    ,185.152.128.5:10197
                    ,185.152.128.66:10190
                    ,185.152.128.61:10411
                    ,185.152.128.80:10193
                    ,185.152.128.52:10068
                    ,185.152.128.9:10206
                    ,185.152.128.52:10072
                    ,185.152.128.70:10187
                    ,185.152.128.52:10074
                    ,185.152.128.121:10175
                    ,185.152.128.116:10197
                    ,185.152.128.34:10454
                    ,185.152.128.27:10109
                    ,185.152.128.114:10197
                    ,185.152.128.5:10198
                    ,185.152.128.109:10787
                    ,185.152.128.50:10391
                    ,185.152.128.19:10093
                    ,185.152.128.79:10204
                    ,185.152.128.66:10191
                    ,185.152.128.107:10498
                    ,185.152.128.129:10202
                    ,185.152.128.118:10215
                    ,185.152.128.28:10441
                    ,185.152.128.3:10221
                    ,185.152.128.28:10442
                    ,185.152.128.29:10400
                    ,185.152.128.22:10423
                    ,185.152.128.94:10610
                    ,185.152.128.15:10222
                    ,185.152.128.95:10505
                    ,185.152.128.39:10088";

        $proxies = explode(',', $proxies);

        foreach ($proxies as $x => $value) {
            $proxies[$x] = trim($value);
        }

            $index =file_get_contents("proxy.txt");
            $index = intval($index);

            // $index =9;
            $proxy = $proxies[$index];

            $new_index = $index+1;
            if($new_index == 10)
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
        // echo $proxy;
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        $username = '1543amrsamo';
        $password = 'bakrbakr';

        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
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
            $parameters = urlencode("ig_hashtag($hashtag) { media.after($max_id,$count) {   count,   nodes {     caption,     code, location,   $comments,     date,     dimensions {       height,       width     },     display_src,     id,     is_video,     likes {       count     },     owner {       id,       username,       full_name,       profile_pic_url,     biography   ,follows{count}  ,followed_by{count} ,media{count} ,external_url     },     thumbnail_src,     video_views,     video_url   },   page_info }  }");
        }
        else
        {
            $parameters = urlencode("ig_hashtag($hashtag) { media.first($count) {   count,   nodes {     caption,     code, location,   $comments,     date,     dimensions {       height,       width     },     display_src,     id,     is_video,     likes {       count     },     owner {       id,       username,       full_name,       profile_pic_url,     biography   ,follows{count}  ,followed_by{count} ,media{count} ,external_url, email    },     thumbnail_src,     video_views,     video_url   },   page_info }  }");
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
<?php

namespace App\Services;
use App\Constant;
use App\Models\Token;

require app_path('../vendor/facebook/graph-sdk/src/Facebook/autoload.php');

class Facebook
{
    public $token;
    public $postChecked = [];

    public function __construct()
    {

    }

    public function setToken($token) {
        $this->token = $token;
        return $this;
    }

    public function curl($url, $jsonDecode = true, $method = 'GET', $postFields='') {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POSTFIELDS,$postFields);
        }

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        return $jsonDecode ? json_decode($result) : $result;
    }

    /**
     * Get user profile by token
     */
    public function getLastComment($token='', $postID, $limit=1) {
        $token = $token ?: $this->token;
        $params = [
            'access_token'  => $token
        ];
        $url = "https://graph.facebook.com/v4.0/$postID/comments?order=reverse_chronological&filter=stream&summary=1&limit=$limit&".http_build_query($params);
        return $this->curl($url);
    }

    public function getCommentNumber($token='', $postID) {
        $token = $token ?: $this->token;
        $params = [
            'access_token'  => $token
        ];
        $url = "https://graph.facebook.com/v4.0/$postID/comments?summary=1&limit=0&".http_build_query($params);
        return $this->curl($url);
    }

    public function getFeeds($token='', $fanpageID) {
        $fanpageID = trim($fanpageID);
        $token = $token ?: $this->token;
        $params = [
            'access_token'  => $token
        ];
        $url = "https://graph.facebook.com/v4.0/$fanpageID/feed?fields=created_time,id,permalink_url&limit=100&".http_build_query($params);
        return $this->curl($url);
    }

    public function getFeeds2($token='', $fanpageID) {
        $fanpageID = trim($fanpageID);
        $token = $token ?: $this->token;
        $params = [
            'access_token'  => $token
        ];
        $url = "https://graph.facebook.com/v4.0/$fanpageID/feed?fields=created_time,from&limit=100&".http_build_query($params);
        return $this->curl($url);
    }

    public function getFanpageID($token='', $fanpage) {
        $fanpage = trim($fanpage);
        $token = $token ?: $this->token;
        $params = [
            'access_token'  => $token
        ];
        $url = "https://graph.facebook.com/v4.0/$fanpage&".http_build_query($params);
        $data = $this->curl($url);
        if (!$data || !property_exists($data, 'id')) {
            return 0;
        }
        return $data->id;
    }

    public function searchFanpage($token='', $key) {
        $key = trim($key);
        $token = $token ?: $this->token;
        $params = [
            'access_token'  => $token,
            'q'             => $key,
            'limit'         => 1000,
        ];
        $url = "https://graph.facebook.com/v4.0/pages/search?".http_build_query($params);
        return $this->curl($url);
    }

    public function getReplies($token='', $commentID) {
        $commentID = trim($commentID);
        $token = $token ?: $this->token;
        $params = [
            'access_token'  => $token,
        ];
        $url = "https://graph.facebook.com/v4.0/$commentID?fields=comments&".http_build_query($params);
        $data = $this->curl($url);

        if (!$data || !property_exists($data, 'comments')) {
            return [];
        }

        if (!$data->comments || !property_exists($data->comments, 'data')) {
            return [];
        }

        return $data->comments->data;
    }


    /**
     * Reply to a comment
     */
    public function replyComment($token='', $commentID, $message) {
        $postField = [
            'message'       => $message,
            'access_token'  => $token,
        ];
        $url = "https://graph.facebook.com/v4.0/$commentID/comments";
        return $this->curl($url, true, 'POST', http_build_query($postField));
    }
}

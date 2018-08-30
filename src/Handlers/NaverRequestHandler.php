<?php

class NaverRequestHandler
{

    public function __construct($accessToken)
    {
        $this->header_get = $this->_makeHeaderGet($accessToken);
        $this->header_post = $this->_makeHeaderPost($accessToken);
        $this->header_post_data =
        $this->_makeHeaderPostData($accessToken);
    }

    public function get($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header_get);

        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    public function post($url, $body)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header_post);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    public function postData($url, $body)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header_post_data);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    public function patch($url, $body)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header_post);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    public function delete($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header_get);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    private static function _makeHeaderGet($accessToken)
    {
        return [
            'X-Booking-Naver-Role: AGENCY',
            "Authorization: ${accessToken}",
        ];
    }

    private static function _makeHeaderPost($accessToken)
    {
        $header = self::_makeHeaderGet($accessToken);
        array_push($header, 'Content-Type: application/json');
        return $header;
    }

    private static function _makeHeaderPostData($accessToken)
    {
        $header = self::_makeHeaderGet($accessToken);
        array_push($header, 'Content-Type: multipart/form-data');
        return $header;
    }

}

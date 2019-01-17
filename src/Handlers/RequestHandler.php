<?php
namespace NaverBooking\Handlers;

class RequestHandler
{

    public function __construct($accessToken)
    {
        $this->access_token = $accessToken;
        $this->header_get = $this->_makeHeaderGet($accessToken);
        $this->header_post = $this->_makeHeaderPost($accessToken);
        $this->header_post_data =
        $this->_makeHeaderPostData($accessToken);
    }

    public function get($url, $http_success_codes = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header_get);

        if (!empty($http_success_codes)) {
            $this->_failOnNonHttpCodes($ch, $res, $http_success_codes);}

        curl_close($ch);

        return $res;
    }

    public function post($url, $body, $http_success_codes = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header_post);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        $res = curl_exec($ch);
        if (!empty($http_success_codes)) {
            $this->_failOnNonHttpCodes($ch, $res, $http_success_codes);}

        curl_close($ch);

        return $res;
    }

    public function postData($url, $body, $http_success_codes = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header_post_data);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        $res = curl_exec($ch);
        if (!empty($http_success_codes)) {
            $this->_failOnNonHttpCodes($ch, $res, $http_success_codes);}

        curl_close($ch);

        return $res;
    }

    public function patch($url, $body, $http_success_codes = []
    ) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header_post);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        $res = curl_exec($ch);
        if (!empty($http_success_codes)) {
            $this->_failOnNonHttpCodes($ch, $res, $http_success_codes);}

        curl_close($ch);

        return $res;
    }

    public function delete($url, $http_success_codes = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header_get);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        $res = curl_exec($ch);
        if (!empty($http_success_codes)) {
            $this->_failOnNonHttpCodes($ch, $res, $http_success_codes);}

        curl_close($ch);

        return $res;
    }

    public function getHeadersGet()
    {
        return [
            'X-Booking-Naver-Role' => 'AGENCY',
            'Authorization' => $this->access_token,
        ];
    }

    private static function _setFailOnError(&$ch, $bool = true)
    {
        curl_setopt($ch, CURLOPT_FAILONERROR, $bool);
    }

    private static function _failOnNonHttpCodes($ch, $res, $http_success_codes)
    {
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (!in_array($responseCode, $http_success_codes)) {
            throw new \Exception($res, $responseCode);}
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

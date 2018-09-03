<?php

require_once dirname(__FILE__) . "/NaverServiceBase.php";

class NaverMiscService extends NaverServiceBase
{

    public function searchAddress($query, $pageSize = 1,
        $reformatAddress = true) {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.0/addresses?" .
            "query=${query}&pageSize=${pageSize}");

        return json_decode($res, true);
    }

    /**
     * Returns imageUrl on success.
     */
    public function uploadImageFile($fileLoc, $toJSON = false)
    {
        $imageFile = new CURLFile($fileLoc);
        $res = $this->requestHandler->postData(
            $this->hostUri . "/v3.0/images", ['imageFile' => $imageFile]);
        if ($toJSON) {
            return json_decode($res, true);
        } else {
            return json_decode($res, true)['imageUrl'];
        }
    }

    /**
     * Returns imageUrl on success.
     */
    public function uploadImageUrl($imageUrl, $toJSON = false)
    {
        $res = $this->requestHandler->postData(
            $this->hostUri . "/v3.0/images", ['imageUrl' => $imageUrl]);
        if ($toJSON) {
            return json_decode($res, true);
        } else {
            return json_decode($res, true)['imageUrl'];
        }
    }

}

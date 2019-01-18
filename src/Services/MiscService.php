<?php
namespace NaverBooking\Services;

require_once dirname(__FILE__) . "/ServiceBase.php";

class MiscService extends ServiceBase
{

    public function urlPostImage() {
        return $this->hostUri . '/v3.0/images';
    }

    public function searchAddress($query, $pageSize = 1,
        $reformatAddress = true) {
        $query = urlencode($query);
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.0/addresses?" .
            "query=${query}&pageSize=${pageSize}", [200]);

        return json_decode($res, true);
    }

    /**
     * Returns imageUrl on success.
     */
    public function uploadImageFile($fileLoc, $toJSON = false)
    {
        $imageFile = new \CURLFile($fileLoc);
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

<?php
namespace NaverBooking\Services;

use NaverBooking\Helpers\ArrayHelper;
use NaverBooking\Objects\Business;
use NaverBooking\Services\ServiceBase;

require_once dirname(__FILE__) . "/ServiceBase.php";

class BusinessService extends ServiceBase
{
    public function getBusinesses($accountName, $size, $page)
    {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.0/businesses?account=${accountName}&" .
            "page=${page}&size=${size}");
        return json_decode($res, true);
    }

    public function getBusiness($businessId)
    {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.1/businesses/{$businessId}");
        return json_decode($res);
    }

    public function getBusinessIdsByBusinessName($accountName,
        $businessName) {
        $businesses = $this->getBusinesses($accountName);
        return ArrayHelper::mapForKey('name', $businessName,
            'businessId', $businesses);
    }

    /**
     * Returns the first occurence.
     */
    public function getBusinessIdByBusinessName($accountName, $businessName)
    {
        return $this->getBusinessIdsByBusinessName($accountName, $businessName)[0];
    }

    public function getBusinessesByBusinessName($accountName, $businessName)
    {
        $businesses = $this->getBusinesses($accountName);
        return ArrayHelper::searchForKey('name', $businessName, $businesses);
    }

    public function createBusiness(Business $business)
    {
        $res = $this->requestHandler->post(
            $this->hostUri . "/v3.1/businesses", json_encode($business));
        return json_decode($res);
    }

    public function editBusiness($businessId, array $data)
    {
        $data['businessId'] = $businessId;
        $res = $this->requestHandler->patch(
            $this->hostUri . "/v3.1/businesses/${businessId}",
            json_encode($data));
        return $res;
    }

    /**
     * 업체 매핑시 기존에 등록되어있는 업체의 상품들은 모두 미노출 처리 됩니다.
     * 미노출된 상품들은 상품 수정을통해 대행사의 상품ID를 입력후 노출 처리 하시면 됩니다.
     *
     * naverId : 매핑 변경 하려는 네이버 서비스를 생성한 네이버 아이디.
     * businessId : 매핑 변경 하려는 네이버 서비스 ID.
     * agencyKey : 대행사에서 사용하는 업체 ID.
     */
    public function mapBusiness($naverUserId, $businessId, $agencyKey)
    {
        $http_success_codes = [200, 201, 204];

        // true 면 대행권 획득, false 면 대행권 해지 요청.
        $data['isAgencyConnected'] = true;
        $data['isAgencyKeyUsed'] = true;
        $data['agencyKey'] = $agencyKey;
        $data['naverId'] = $naverUserId;
        $res = $this->requestHandler->patch(
            $this->hostUri . "/v3.1/businesses/${businessId}/agency-mappings",
            json_encode($data), $http_success_codes);
        return $res;
    }

    public function unmapBusiness($naverUserId, $businessId, $agencyKey)
    {
        $http_success_codes = [200, 201, 204];

        // true 면 대행권 획득, false 면 대행권 해지 요청.
        $data['isAgencyConnected'] = false;
        $data['isAgencyKeyUsed'] = true;
        $data['agencyKey'] = $agencyKey;
        $data['naverId'] = $naverUserId;
        $res = $this->requestHandler->patch(
            $this->hostUri . "/v3.1/businesses/${businessId}/agency-mappings",
            json_encode($data), $http_success_codes);
        return $res;
    }

    /**
     * More specific hard-coded instructions. May need to be modified if data
     * representation within Business class changes.
     * $address[jibun/road address, address detail]
     */
    public function editBusinessAddressById(int $businessId, array $address,
        $isRoadAddr = false) {
        $business = Business::example();
        $newAddressJson;
        if ($isRoadAddr) {
            $newAddressJson = $business->setAddressRoad($address[0], true);
        } else {
            $newAddressJson = $business->setAddressJibun($address[0], true);
        }
        $newAddressJson = array_merge_recursive($newAddressJson,
            $business->setAddressDetail($address[1], true));

        $data['businessId'] = $businessId;
        $data = array_merge_recursive($data, $newAddressJson);

        $res = $this->requestHandler->patch(
            $this->hostUri . "/v3.1/businesses/${businessId}",
            json_encode($data), true);
        return $res;
    }
    

}

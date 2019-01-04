<?php
namespace NaverBooking\Services;

use NaverBooking\Objects\Option;

require_once dirname(__FILE__) . "/ServiceBase.php";

class OptionService extends ServiceBase
{

    public function getOptions($businessId)
    {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.1/businesses/${businessId}/options");
        return json_decode($res, true);
    }

    public function getOption($businessId, $optionId)
    {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.1/businesses/${businessId}/" .
            "options/${optionId}");
        return json_decode($res, true);
    }

    public function getOptionCategories($businessId)
    {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.1/businesses/${businessId}/" .
            "option-categories?projections=option");
        return json_decode($res, true);
    }

    public function getOptionCategoryIdByName($businessId, $categoryName)
    {
        $categories = $this->getOptionCategories($businessId);
        $categoryId = ArrayHelper::mapForKey('name', $categoryName, 'categoryId',
            $categories)[0];
        return $categoryId;
    }

    public function getDefaultOptionCategoryId($businessId)
    {
        return $this->getOptionCategoryIdByName($businessId, '카테고리 미지정');
    }

    /**
     * Product 에 연결 :
     * getOptionCategoryIdByName($businessId, '카테고리 미지정') 통해 categoryId 받은 후
     * Option 에 setCategoryId(categoryid) 해야함.
     */
    public function createOption($businessId, Option $option)
    {
        $res = $this->requestHandler->post(
            $this->hostUri . "/v3.1/businesses/${businessId}/options",
            json_encode($option));
        return json_decode($res);
    }

    public function editOption($businessId, $optionId,
        array $data) {
        $res = $this->requestHandler->patch(
            $this->hostUri . "/v3.1/businesses/${businessId}" .
            "/options/${optionId}",
            json_encode($data));
        return $res;
    }

    public function deleteOption($businessId, $optionId)
    {
        $res = $this->requestHandler->delete(
            $this->hostUri . "/v3.1/businesses/${businessId}/" .
            "options/${optionId}");
        if (isset($res)) {
            return json_decode($res, true);
        } else {
            return ['status' => 200];
        }
    }

    public function deleteAllOptions($businessId)
    {
        $optionIds = ArrayHelper::extract('optionId',
            $this->getOptions($businessId));
        $param = implode(',', $optionIds);
        $res = $this->requestHandler->delete(
            $this->hostUri . "/v3.1/businesses/${businessId}/" .
            "options/${param}");

        $ret = json_decode($res, true);
        if (isset($ret)) {
            return $ret;
        } else {
            return ['response' => 200];
        }
    }
}

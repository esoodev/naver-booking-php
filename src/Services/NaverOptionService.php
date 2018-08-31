<?php

require_once dirname(__FILE__) . "/NaverServiceBase.php";
require_once dirname(__FILE__) . "/../Objects/NaverOption.php";

class NaverOptionService extends NaverServiceBase
{

    public function getOptions(int $businessId)
    {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.1/businesses/${businessId}/options");
        return json_decode($res, true);
    }

    public function getOption(int $businessId, int $optionId)
    {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.1/businesses/${businessId}/" .
            "options/${optionId}");
        return json_decode($res, true);
    }

    public function getOptionCategories(int $businessId)
    {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.1/businesses/${businessId}/" .
            "option-categories?projections=option");
        return json_decode($res, true);
    }

    public function getOptionCategoryIdByName(int $businessId, $categoryName)
    {
        $categories = $this->getOptionCategories($businessId);
        $categoryId = ArrayHelper::mapForKey('name', $categoryName, 'categoryId',
            $categories)[0];
        return $categoryId;
    }

    public function getDefaultOptionCategoryId(int $businessId)
    {
        return $this->getOptionCategoryIdByName($businessId, '카테고리 미지정');
    }

    /**
     * Product 에 연결 :
     * getOptionCategoryIdByName($businessId, '카테고리 미지정') 통해 categoryId 받은 후
     * Option 에 setCategoryId(categoryid) 해야함.
     */
    public function createOption(int $businessId, Option $option)
    {
        $res = $this->requestHandler->post(
            $this->hostUri . "/v3.1/businesses/${businessId}/options",
            json_encode($option));
        return json_decode($res);
    }

    public function editOption(int $businessId, int $optionId,
        array $data) {
        $res = $this->requestHandler->patch(
            $this->hostUri . "/v3.1/businesses/${businessId}" .
            "/options/${optionId}",
            json_encode($data));
        return $res;
    }

    public function deleteOption(int $businessId, int $optionId)
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

    public function deleteAllOptions(int $businessId)
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

<?php

require_once dirname(__FILE__) . "/NaverServiceBase.php";
require_once dirname(__FILE__) . "/../Objects/NaverProduct.php";

class NaverProductService extends NaverServiceBase
{

    public function getProducts(int $businessId)
    {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.1/businesses/${businessId}/biz-items");
        return json_decode($res, true);
    }

    public function getProduct(int $businessId, int $productId)
    {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.1/businesses/${businessId}/" .
            "biz-items/${productId}");
        return json_decode($res, true);
    }

    public function createProduct(int $businessId, Product $product)
    {
        $res = $this->requestHandler->post(
            $this->hostUri . "/v3.1/businesses/${businessId}/biz-items",
            json_encode($product));
        return json_decode($res);
    }
}

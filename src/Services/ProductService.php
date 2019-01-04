<?php
namespace NaverBooking\Services;

use NaverBooking\Objects\Product;

require_once dirname(__FILE__) . "/ServiceBase.php";

class ProductService extends ServiceBase
{

    public function getProducts($businessId)
    {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.1/businesses/${businessId}/biz-items");
        return json_decode($res, true);
    }

    public function getProduct($businessId, $productId)
    {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.1/businesses/${businessId}/" .
            "biz-items/${productId}");
        return json_decode($res, true);
    }

    public function createProduct($businessId, Product $product)
    {
        $res = $this->requestHandler->post(
            $this->hostUri . "/v3.1/businesses/${businessId}/biz-items",
            json_encode($product));
        return json_decode($res);
    }

    public function editProduct($businessId, $productId, array $data)
    {
        $res = $this->requestHandler->patch(
            $this->hostUri . "/v3.1/businesses/${businessId}/" .
            "biz-items/${productId}",
            json_encode($data));
        return $res;
    }
}

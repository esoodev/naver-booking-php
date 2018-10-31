<?php

require_once dirname(__FILE__) . "/NaverDictionary.php";
require_once dirname(__FILE__) . "/../Helpers/ArrayHelper.php";

/**
 * NaverRefundPolicy
 */
class NaverRefundPolicy
{

    public function __construct(array $data)
    {
        $this->description = '당일 환불 불가입니다.';
        $this->policies = [
            ['baseDay' => 0, 'rate' => 0],
        ];

        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public static function create($data = [])
    {
        return new self($data);
    }

    /**
     * 기본 환불 규정 생성
     */
    public static function createDefault($description = '')
    {
        if (empty($description)) {
            $description = "2일 전 취소 : 취소수수료 없음\n" .
                "* 1일 전 취소 : 10% 수수료 발생\n" .
                "* 당일 취소 : 환불 불가\n";
        }
        return new self([
            'description' => $description,
            'policies' => [
                ['baseDay' => 0, 'rate' => 0],
                ['baseDay' => 1, 'rate' => 90],
                ['baseDay' => 2, 'rate' => 100],
            ],
        ]);
    }

    /**
     * SETTERS
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function addRefundRate($daysAway, $refundRateInPercent)
    {
        if (array_key_exists($daysAway, $this->policies)) {
            throw new Exception("Refund rate exists for ${daysAway} days away " .
                "from usage date : ${refundRateInPercent}%");}

        array_push($this->policies, [
            'baseDay' => $daysAway,
            'rate' => $refundRateInPercent,
        ]);
        return $this->policies;
    }

    /**
     * GETTERS
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function getRefundRates()
    {
        return $this->policies;
    }

}

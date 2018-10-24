<?php

require_once dirname(__FILE__) . "/NaverDictionary.php";
require_once dirname(__FILE__) . "/../Helpers/ArrayHelper.php";

/**
 * NaverReservation 는 API 문서상 Booking 과 동일.
 * Booking Transaction / 예약 상태 업데이트 (from 대행사 to 네이버)
 */
class NaverReservationStatusTo
{
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'status':
                    $this->setStatus($value);
                    break;
                case 'cancelledBy':
                    $this->setCancelBy($value);
                    break;
                case 'refundType':
                    $this->setRefundType($value);
                    break;
                default:
                    $this->{$key} = $value;
            }
        }
    }

    public function createConfirmed($desc, $data = [])
    {
        $data['status'] = 'CONFIRMED';
        $data['bookingGuide'] =
            $desc; // 예약 확정 시 업주가 고객에게 주는 설명
        return new self($data);
    }
    public function createCancelled($desc, $data = [])
    {
        $data['status'] = 'CANCELLED';
        $data['cancelledDesc'] =
            $desc; // 취소 사유
        return new self($data);
    }
    public function createCompleted($pin, $data = [])
    {
        $data['status'] = 'COMPLETED';
        $data['completedPinValue'] =
            $pin; // 이용완료 시 필요한 PIN
        return new self($data);
    }

    /**
     * SETTERS
     */
    public function setRefundType($refundType)
    {
        $validRefundTypes = array_keys(NaverDictionary::REFUND_TYPES);

        if (!in_array($refundType, $validRefundTypes)) {
            throw new Exception("Invalid refund type '${refundType}'. " .
                "Valid types are : " . implode(" ", $validRefundTypes));
        }
        $this->refundType = $refundType;
    }

    public function setRefundPrice($price)
    {
        $this->refundPrice = $price;
    }

    public function setRefundRate($rate)
    {
        $this->refundRate = $rate;
    }

    public function setStatus($status)
    {
        $validStatuses = NaverDictionary::BOOKING_STATUS_STRINGS_TO;
        if (!in_array($status, $validStatuses)) {
            throw new Exception("Invalid booking status '${status}'. " .
                "Valid statuses are : " . implode(" ", $validStatuses));
        }
        $this->status = $status;
    }

    public function setConfirmDesc($desc)
    {
        $this->bookingGuide = $desc;
    }

    public function setCancelBy($cancelSource)
    {
        $validCancelSources = NaverDictionary::BOOKING_CANCEL_SOURCES;

        if (!in_array($cancelSource, $validCancelSources)) {
            throw new Exception("Invalid cancel source '${cancelSource}'. " .
                "Valid sources are : " . implode(" ", $validCancelSources));
        }
        $this->cancelledBy = $cancelSource;
    }

    public function setCancelDesc($desc)
    {
        $this->cancelledDesc = $desc;
    }

    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

}

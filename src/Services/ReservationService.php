<?php
namespace NaverBooking\Services;

use NaverBooking\Objects\Reservation;
use NaverBooking\Objects\Dictionary;

require_once dirname(__FILE__) . "/ServiceBase.php";

class ReservationService extends ServiceBase
{

    public function getReservation($businessId, $bookingId)
    {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.0/businesses/${businessId}/bookings/${bookingId}");
        return json_decode($res, true);
    }

    /**
     * 해당 상품에 대한 예약 건들을 조회함.
     * 아래는 페이징 옵션과 필터 :
     * $options = [
     *     $page = 0;
     *     $size = 0;
     *     $statuses = [
     *         'confirmed', 'cancelled',
     *         'requested', 'completed',
     *     '];]
     */
    public function getReservations($businessId, array $options)
    {
        $page = $option['page'];
        $size = $option['size'];
        $bookingStatusCodes = $this->_toStatusCodes($option['statuses']);

        $res = $this->requestHandler->get(
            $this->hostUri . "v3.0/businesses/${businessId}/bookings?" .
            "page=${page}&size=${size}&bookingStatusCodes=${bookingStatusCodes}");
        return json_decode($res, true);
    }

    /**
     * $data 는 ReservationStatusTo 형식이다.
     */
    public function setReservationStatus($businessId, $productId,
        $reservationId, array $data) {
        $res = $this->requestHandler->patch(
            $this->hostUri . "/v3.1/businesses/${businessId}/" .
            "biz-items/${productId}/bookings/${bookingId}",
            json_encode($data));
        return $res;
    }

    /**
     * Convert array of status strings to a string of status codes
     * deliminated by ','
     */
    private function _toStatusCodes(array $statuses)
    {
        $bookingStatusCodes = [];

        if (!empty($statuses)) {
            foreach ($statuses as &$status) {
                $status_code = Dictionary::BOOKING_STATUS_CODES[strroupper($status)];
                if (empty($status_code)) {
                    throw new Exception("${status} is not a valid status.");
                }
                array_push($bookingStatusCodes, $status_code);
            }
        }
        return implode(',', $bookingStatusCodes);
    }
}

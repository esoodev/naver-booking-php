<?php
namespace NaverBooking\Objects;

use NaverBooking\Objects\Reservation;

/**
 * NaverReservation 는 API 문서상 Booking 과 동일.
 */
class ReservationEdit extends Reservation
{

    public function __construct(array $data)
    {foreach ($data as $key => $value) {$this->{$key} = $value;}}

    public static function create(array $data)
    {return new self($data);}

    /**
     * GETTERS
     */

    public function getNaverUserId()
    {throw new \Exception('Cannot extract Naver user ID from edit request.');}

    public function getNaverUserName()
    {return $this->userName;}

    public function getNaverUserPhoneNumber()
    {return $this->userPhone;}

    public function getNaverUserEmail()
    {return $this->userEmail;}

    public function getProductName()
    {return $this->bizItemName;}

    public function getReservationRequestMessage()
    {throw new \Exception('Cannot extract reservation request message from edit request.');}

    public function getTotalPrice()
    {return $this->totalPrice;}

    public function getPartySize()
    {return $this->resrvCnt;}

    public function getMenuPurchase()
    {throw new \Exception('Cannot extract purchased menu from edit request.');}

    public function getDateTimeString($format = 'Y-m-d H:i:s')
    {throw new \Exception('Use getStartDateTimeString() or getEndDateTimeString().');}

    public function getStartDateTimeString($format = 'Y-m-d H:i:s')
    {return (new \DateTime($this->bookingStartDateTime))->format($format);}

    public function getEndDateTimeString($format = 'Y-m-d H:i:s')
    {return (new \DateTime($this->bookingEndDateTime))->format($format);}

    public function getPreviousBookingId()
    {return $this->previousBookingId;}

    /**
     * eg) 2018-10-16
     */
    public function getDateString($format = 'Y-m-d')
    {throw new \Exception('Use getStartDateString() or getEndDateString().');}

    public function getStartDateString($format = 'Y-m-d')
    {return (new \DateTime($this->resrvStart))->format($format);}

    public function getEndDateString($format = 'Y-m-d')
    {return (new \DateTime($this->resrvEnd))->format($format);}

    /**
     * eg) 07:20
     */
    public function getTimeString($format = 'H:i')
    {throw new \Exception('Use getStartTimeString() or getEndTimeString().');}

    public function getStartTimeString($format = 'H:i')
    {return (new \DateTime($this->bookingStartDateTime))->format($format);}

    public function getEndTimeString($format = 'H:i')
    {return (new \DateTime($this->bookingEndDateTime))->format($format);}

    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

}

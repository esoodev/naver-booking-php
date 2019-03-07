<?php
namespace NaverBooking\Services;

use NaverBooking\Objects\RestaurantSchedule;
use NaverBooking\Services\ServiceBase;

require_once dirname(__FILE__) . "/ServiceBase.php";

class ScheduleService extends ServiceBase
{

    public function getSchedule($businessId, $productId, $scheduleId)
    {
        return RestaurantSchedule::create(json_decode($this->requestHandler->get(
            $this->hostUri . "/v3.1/businesses/${businessId}/biz-items/${productId}"
            . "/schedules/${scheduleId}", [200]), true));
    }

    public function getSchedules($businessId, $productId, $size = 20, $page = 0)
    {
        $res = json_decode($this->requestHandler->get(
            $this->hostUri . "/v3.1/businesses/${businessId}/" .
            "biz-items/${productId}/schedules?" .
            "page=${page}&size=${size}", [200]), true);
        $schedules = [];
        foreach ($res as $scheduleData) {
            array_push($schedules, RestaurantSchedule::create($scheduleData));}
        return $schedules;
    }

    public function createSchedule($businessId, $productId,
        RestaurantSchedule $schedule) {
        return $this->createSchedules($businessId, $productId, [$schedule])[0];
    }

    public function createSchedules($businessId, $productId, $schedules)
    {
        $res = $this->requestHandler->post(
            $this->hostUri . "/v3.1/businesses/${businessId}/biz-items/${productId}"
            . "/schedules", json_encode($schedules), [201]);
        $scheduleData = json_decode($res, true);
        $schedules = [];
        foreach ($scheduleData as $data) {
            array_push($schedules, RestaurantSchedule::create($data));}
        return $schedules;
    }

    public function deleteSchedule($businessId, $productId, $scheduleId)
    {return $this->deleteSchedules($businessId, $productId, [$scheduleId]);}

    public function deleteSchedules($businessId, $productId, $scheduleIds)
    {
        $ids = implode(',', $scheduleIds);
        $res = $this->requestHandler->delete(
            $this->hostUri . "/v3.1/businesses/${businessId}/biz-items/${productId}"
            . "/schedules/${scheduleIds}", [204]);
        return json_decode($res);
    }

    public function editSchedule($businessId, $productId, $scheduleId,
        RestaurantSchedule $schedule) {
        $res = $this->requestHandler->patch(
            $this->hostUri . "/v3.1/businesses/${businessId}/biz-items/${productId}"
            . "/schedules/${scheduleId}", $schedule->toJson(), [204]);
        return json_decode($res);
    }

}

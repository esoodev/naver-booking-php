<?php
namespace NaverBooking\Services;

use NaverBooking\Services\ServiceBase;

require_once dirname(__FILE__) . "/ServiceBase.php";

class ScheduleService extends ServiceBase
{
    public function createSchedule($businessId, $productId, $scheduleId)
    {return $this->createSchedules($businessId, $productId, [$scheduleId]);}

    public function createSchedules($businessId, $productId, $schedules)
    {
        $res = $this->requestHandler->post(
            $this->hostUri . "/v3.1/businesses/${businessId}/biz-items/${productId}"
            . "/schedules", json_encode($schedules), [201]);
        return json_decode($res);
    }

    public function deleteSchedule($businessId, $productId, $scheduleId)
    {return $this->deleteSchedules($businessId, $productId, [$scheduleId]);}

    public function deleteSchedules($businessId, $productId, $scheduleIds)
    {
        $ids = implode(',', $scheduleIds);
        $res = $this->requestHandler->delete(
            $this->hostUri . "/v3.1/businesses/${businessId}/biz-items/${productId}"
            . "/schedules/${ids}", [204]);
        return json_decode($res);
    }
}

<?php
namespace NaverBooking\Objects;

class RestaurantSchedule
{

    public function __construct($data = null)
    {
        foreach ($data as $key => $value) {$this->{$key} = $value;}
    }

    public static function create($data = [])
    {
        $schedule = new self($data);
        $schedule->setName('기본');
        $schedule->setBlockUnitInMinutes(30);
        $schedule->setMinBookingCount(1);
        $schedule->setMaxBookingCount(100);
        $schedule->setPerBlockStock(10);
        $schedule->setStartDateTime((new \DateTime())->format('Y-m-d') . ' 00:00');
        $schedule->setEndDateTime('2029-01-10 15:00');
        $schedule->setAssignToOptions([]);
        return $schedule;
    }

    public static function createExample()
    {return new self(self::requiredFields());}

    /**
     * 요일별 생성
     */
    public static function createByDay($day, $data = [])
    {
        $day = strtolower($day);
        try {
            // $day = array_key_exists($Dictionary::SCHEDULE_DAYS) ?
            // Dictionary::SCHEDULE_DAYS[$day] : $day;
        } catch (\Exception $e) {throw new \Exception("Invalid day '${$day}'.");}

        return self::create(['weekdays' => [$day]]);
    }

    public static function requiredFields()
    {
        $f['startDate'] = '2019-02-18'; // 스케줄 시작일 (yyyy-MM-dd)
        $f['endDate'] = '2029-02-18'; // 스케줄 종료일 (yyyy-MM-dd)
        $f['startTime'] = '00:00'; // 스케줄 시작시간 (HH:mm)
        $f['endTime'] = '23:30'; // 스케줄 종료시간 (HH:mm)
        $f['weekdays'] = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun']; // 반복 요일
        $f['duration'] = 30; // 예약 단위시간(분) : 30, 60
        $f['name'] = '기본'; // 스케줄 명
        $f['stock'] = 30; // 시간대 재고 (일단위로 적용됨)
        $f['minBookingCount'] = 1; // 최소 예약수량
        $f['maxBookingCount'] = 10; // 최대 예약수량
        return $f;
    }

    public static function optionalFields()
    {
        /**
         * 가격권종 사용할 경우 권종 리스트
         * (스케쥴에 매핑할 가격권종 아이디(priceId)를 노출할 순서대로 입력)
         */
        $f['prices'] = [];
        return $f;
    }

    /**
     * MISC
     */

    /**
     * GETTERS
     */

    public function getStartDateTime()
    {return new \DateTime($this->getStartDateTimeString());}

    public function getEndDateTime()
    {return new \DateTime($this->getEndDateTimeString());}

    public function getStartDateTimeString($format = 'Y-m-d H:i')
    {
        $datestring = $this->startDate . ' ' . $this->startTime;
        if ($format === 'Y-m-d H:i') {return $datestring;} else {
            return (new \DateTime($this->dateTime))->format($format);}
    }

    public function getEndDateTimeString($format = 'Y-m-d H:i')
    {
        $datestring = $this->endDate . ' ' . $this->endTime;
        if ($format === 'Y-m-d H:i') {return $datestring;} else {
            return (new \DateTime($this->dateTime))->format($format);}
    }

    public function getStartDate()
    {return $this->startDate;}

    public function getEndDate()
    {return $this->endDate;}

    public function getStartTime()
    {return $this->startTime;}

    public function getEndTime()
    {return $this->endTime;}

    public function getActiveWeekDays()
    {return $this->weekdays;}

    public function getBlockUnitInMinutes()
    {return $this->duration;}

    public function getName()
    {return $this->name;}

    public function getPerBlockStock()
    {return $this->stock;}

    public function getMinBookingCount()
    {return $this->minBookingCount;}

    public function getMaxBookingCount()
    {return $this->maxBookingCount;}

    public function getAssignToOptions()
    {return $this->options;}

    public function getId()
    {return property_exists($this, 'scheduleId') ? $this->scheduleId : null;}

    /**
     * SETTERS
     */

    public function setStartDateTime($datestring)
    {
        $this->setStartDate($datestring);
        $this->setStartTime($datestring);
    }
    public function setEndDateTime($datestring)
    {
        $this->setEndDate($datestring);
        $this->setEndTime($datestring);
    }

    public function setStartDate($datestring)
    {$this->startDate = (new \DateTime($datestring))->format('Y-m-d');}

    public function setEndDate($datestring)
    {$this->endDate = (new \DateTime($datestring))->format('Y-m-d');}

    public function setStartTime($datestring)
    {$this->startTime = (new \DateTime($datestring))->format('H:i');}

    public function setEndTime($datestring)
    {$this->endTime = (new \DateTime($datestring))->format('H:i');}

    public function setActiveWeekDays(array $weekdays)
    {$this->weekdays = $weekdays;}

    public function setBlockUnitInMinutes(int $minutes)
    {$this->duration = $minutes;}

    public function setName($name)
    {$this->name = $name;}

    public function setPerBlockStock(int $stock)
    {$this->stock = $stock;}

    public function setMinBookingCount(int $count)
    {$this->minBookingCount = $count;}

    public function setMaxBookingCount(int $count)
    {$this->maxBookingCount = $count;}

    public function setAssignToOption(int $optionId)
    {$this->setAssignToOptions([$optionId]);return $this;}

    public function setAssignToOptions(array $optionIds)
    {$this->options = $optionIds;return $this;}

    public function addAssignToOption(int $optionId)
    {array_push($this->options, $optionId);return $this;}

    public function removeAssignToOption(int $optionId)
    {$this->options = array_diff($this->options, [$optionId]);return $this;}

    /**
     * Misc
     */

    public function toJson()
    {
        if (property_exists($this, 'url')) {unset($this->url);}
        return json_encode($this, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

}

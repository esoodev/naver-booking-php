<?php

class NaverDictionary
{

    // 예약 유형 - 하위 리소스가 해당 값을 토대로 생성 됨; 설정 후 변경 불가
    const BUSINESS_TYPE_ID = [
        '숙박' => 3,
        '공연' => 5,
        '전시' => 5,
        '식당' => 6,
    ];

    // 업종코드
    const BUSINESS_CATEGORIES = [
        '기타' => 'DL00',
        '캠핑장' => 'DL00',
        '펜션' => 'DL00',
        '호텔' => 'DL03',
        '모텔' => 'DL03',
        '리조트' => 'DL03',
        '게스트하우스' => 'DL04',
        '행사' => 'DL05',
        '축제' => 'DL05',
        '식당' => 'DL06',
    ];

    // 예약 확정 방법 - 네이버 페이 사용 업체인 경우 CF01를 사용
    const BOOKING_CONFIRM_CODES = [
        '즉시' => 'CF01',
        '관리자 확인 후' => 'CF02',
    ];

    // 업체 시간 관리 단위
    const BOOKING_TIME_UNIT_CODES = [
        '분' => 'RT00',
        '30분' => 'RT01',
        '시간' => 'RT02',
        '일' => 'RT03',
    ];

    // 미사용 티켓 처리 코드
    const UNCOMPLETED_BOOKING_PROCESS_CODES = [
        '완료' => 'UC01',
        '취소' => 'UC02',
    ];

    // 리소스 타입
    const RESOURCE_TYPE_CODES = [
        '대표이미지' => 'FL00',
        '서브이미지' => 'FL01',
    ];

    // 예약 리스트 조회
    const BOOKING_STATUS_CODES = [
        'REQUESTED' => 'RC02',
        'CONFIRMED' => 'RC03',
        'CANCELLED' => 'RC04',
        'COMPLETED' => 'RC05',
    ];

    // 예약 상태 - from 대행사 to 네이버
    const BOOKING_STATUS_STRINGS = [
        'CONFIRMED', 'CANCELLED', 'COMPLETED',
        'READABLE_CODE_COMPLETED', 'PARTIAL_CHANGED',
    ];
}

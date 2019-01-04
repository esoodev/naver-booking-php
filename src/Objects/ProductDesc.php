<?php
namespace NaverBooking\Objects;

class ProductDesc
{

    public function __construct($title = '', $context = '')
    {
        $this->title = $title; // 상세설명 제목 (최소 3자)
        $this->context = $context; // 상세설명 본문 (최소 4자)
        $this->images = []; // 상세설명 이미지 리스트 (최대 이미지 3개)
    }

    /**
     * GETTERS
     */

    public static function create($title, $context)
    {
        return new self($title, $context);
    }

    /**
     * SETTERS
     */

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setDesc($title)
    {
        $this->title = $title;
    }

    public function addImage($src = '', $url = '')
    {
        array_push($this->images,
            [
                'src' => $src,
                'url' => $url,
            ]
        );
    }

    /**
     * MISC
     */

    public function isValid()
    {
        return (
            strlen($this->title) >= 3 &&
            strlen($this->context) >= 4 &&
            count($this->images) <= 3
        );
    }

    public function toArray()
    {
        return [
            'title' => $this->title,
            'context' => $this->context,
            'images' => $this->images,
        ];
    }

}

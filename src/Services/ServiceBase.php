<?php
namespace NaverBooking\Services;

use NaverBooking\Handlers\RequestHandler;
use NaverBooking\Config\NaverBookingConfig;

class ServiceBase
{

    public function __construct($accessToken, $hostType = 'development')
    {
        $this->accessToken = $accessToken;
        $this->requestHandler = new RequestHandler($accessToken);
        $this->hostUri = self::getHostUri($hostType);
    }

    public static function fromAccessToken($accessToken)
    {
        return new self($accessToken);
    }

    public static function getHostUri($hostType)
    {
        switch ($hostType) {
            case 'development':
                return NaverBookingConfig::DEVELOPMENT_URI;
                break;
            case 'production':
                return NaverBookingConfig::PRODUCTION_URI;
                break;
            default:
                return NaverBookingConfig::DEVELOPMENT_URI;
        }
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getBaseHeaders()
    {
        return $this->requestHandler->getHeadersGet();
    }

}

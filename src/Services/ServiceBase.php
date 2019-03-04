<?php
namespace NaverBooking\Services;

use NaverBooking\Config\NaverBookingConfig;
use NaverBooking\Handlers\RequestHandler;

class ServiceBase
{

    public function __construct($accessToken, $hostType = 'development')
    {
        $this->accessToken = $accessToken;
        $this->requestHandler = new RequestHandler($accessToken);
        $this->hostUri = self::getHostUri($hostType);
    }

    public static function create($accessToken, $hostType = 'development')
    {
        return new self($accessToken, $hostType);
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

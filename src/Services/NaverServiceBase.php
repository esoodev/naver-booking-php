<?php

require_once dirname(__FILE__) . "/../Handlers/NaverRequestHandler.php";
require_once dirname(__FILE__) . "/../Helpers/ArrayHelper.php";
require_once dirname(__FILE__) . "/../config/NaverBookingConfig.php";

class NaverServiceBase
{

    public function __construct(string $accessToken, $hostType = 'development')
    {
        $this->requestHandler = new NaverRequestHandler($accessToken);
        $this->hostUri = self::getHostUri($hostType);
    }

    public static function fromAccessToken(string $accessToken)
    {
        return new self($accessToken);
    }

    public static function getHostUri(string $hostType)
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

}

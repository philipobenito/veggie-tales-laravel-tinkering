<?php

namespace App\Enums;

class HttpStatus
{
    public const SUCCESS = 'success';
    public const ERROR = 'error';

    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;
    public const HTTP_ACCEPTED = 202;
    public const HTTP_NO_CONTENT = 204;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_UNAUTHORIZED = 401;
    public const HTTP_FORBIDDEN = 403;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_METHOD_NOT_ALLOWED = 405;
    public const HTTP_CONFLICT = 409;
    public const HTTP_INTERNAL_SERVER_ERROR = 500;
    public const HTTP_NOT_IMPLEMENTED = 501;
    public const HTTP_BAD_GATEWAY = 502;
    public const HTTP_SERVICE_UNAVAILABLE = 503;

    public static function getMessage($code)
    {
        return match ($code) {
            self::HTTP_OK => 'OK',
            self::HTTP_CREATED => 'Created',
            self::HTTP_ACCEPTED => 'Accepted',
            self::HTTP_NO_CONTENT => 'No Content',
            self::HTTP_BAD_REQUEST => 'Bad Request',
            self::HTTP_UNAUTHORIZED => 'Unauthorized',
            self::HTTP_FORBIDDEN => 'Forbidden',
            self::HTTP_NOT_FOUND => 'Not Found',
            self::HTTP_METHOD_NOT_ALLOWED => 'Method Not Allowed',
            self::HTTP_CONFLICT => 'Conflict',
            self::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error',
            self::HTTP_NOT_IMPLEMENTED => 'Not Implemented',
            self::HTTP_BAD_GATEWAY => 'Bad Gateway',
            self::HTTP_SERVICE_UNAVAILABLE => 'Service Unavailable',
            default => 'Unknown error',
        };
    }
}

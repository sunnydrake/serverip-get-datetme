<?php
/*
 * Author: Oleh Marychev aka SunnyDrake
 * Email: sunnydrake7@gmail.com
 * License: GPL3 or later
 */

namespace Sunnydrake\Serverip;

use DateTime;
use Exception;

/**
 * Class ServerGetDateTimeStatusCodes
 * return Status codes for ServerGetDateTime
 */
abstract class ServerGetDateTimeStatusCodes
{
    /**
     * General Response - all is fine,really fine
     */
    const OK = TRUE;
    /**
     * General Response - fail,somethin happens see second param
     */
    const FAIL = FALSE;
    //details
    /**
     * Extended data  - can't connect in time to web api url
     */
    const ERROR_CONNECT = 1;
    /**
     * Extended data  - can't fetch data in time from web api url
     */
    const ERROR_TIMEOUT = 2;
    /**
     * Extended data  - php allow_url_fopen is FALSE
     */
    const ERROR_PHPCONFIG_ALLOW_URL_FOPEN = 3;
    /**
     * Extended data  - error while decoding json reply
     */
    const ERROR_JSON_DECODE = 4;

    /**
     * Extended data  - error while parsing data to DateTime
     */
    const ERROR_DATETIMEPARSE = 5;
    /**
     * Extended data  - error is unknown
     */
    const ERROR_UNKNOWN = 6;
}

/**
 * Class ServerGetDateTime
 * return DateTime of specific ip or current ip (no param) based on http://worldtimeapi.org
 */
class ServerGetDateTime extends ServerGetDateTimeStatusCodes
{
    /**
     * Url of API DateTime by ip API
     * @var string
     */
    public static string $api_url = "http://worldtimeapi.org/api/ip";
    /**
     * Connection Timeout
     * @var int
     */
    public static $connect_timeout = 5;
    /**
     * Fetch data Timeout
     * @var int
     */
    public static int $fetch_timeout = 5;

    /**
     * Format that expected in reply from web api
     * @var string
     */
    public static string $date_time_format = "Y-m-d\TH:i:s.uP";//2021-06-23T16:02:58.691881+03:00

    /**
     * Main function to get DateTime
     * @param string $ip (optional)
     * @return array [ genereral status, DateTime or extended status ]
     */
    static function getDateTime(string $ip = ''): array
    {
        //sanity check
        if (!ini_get("allow_url_fopen")) return [self::FAIL, self::ERROR_PHPCONFIG_ALLOW_URL_FOPEN];
        //get service with timeout
        $old = ini_set('default_socket_timeout', self::$connect_timeout);
        try {
            if (!empty($ip)) {
                $ip = "/" . $ip;
            }
            $file = fopen(self::$api_url . $ip, 'r');
            ini_set('default_socket_timeout', $old);
            if ($file === FALSE) return [self::FAIL, self::ERROR_CONNECT];
            stream_set_timeout($file, self::$fetch_timeout);
            stream_set_blocking($file, 0);
            $contents = '';
            while (!feof($file)) {
                $contents .= fread($file, 8192);
            }
            $info = stream_get_meta_data($file);
            if ($info['timed_out']) return [self::FAIL, self::ERROR_TIMEOUT];
            fclose($file);
            $dt = json_decode($contents);
            if (empty($dt)) return [self::FAIL, self::ERROR_JSON_DECODE];
            if (empty($dt->datetime)) return [self::FAIL, self::ERROR_JSON_DECODE];
            $dti = DateTime::createFromFormat(self::$date_time_format, $dt->datetime);
            if ($dti === FALSE) return [self::FAIL, self::ERROR_DATETIMEPARSE];
            return [self::OK, $dti];
        } catch (Exception $e) { // something is really uncommon
            ini_set('default_socket_timeout', $old);
            return [self::FAIL, self::ERROR_UNKNOWN];
        }
    }
}


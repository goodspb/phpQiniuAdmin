<?php

/**
 * send http status
 * @param integer $code status code
 * @return void
 */
function send_http_status($code)
{
    static $_status = array(
        // Informational 1xx
        100 => 'Continue',
        101 => 'Switching Protocols',
        // Success 2xx
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        // Redirection 3xx
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Moved Temporarily ',  // 1.1
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        // 306 is deprecated but reserved
        307 => 'Temporary Redirect',
        // Client Error 4xx
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        // Server Error 5xx
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        509 => 'Bandwidth Limit Exceeded'
    );
    if (isset($_status[$code])) {
        header('HTTP/1.1 ' . $code . ' ' . $_status[$code]);
        header('Status:' . $code . ' ' . $_status[$code]);
    }
}

/**
 * Safely get child value from an array or an object
 *
 * @param array|object $array Subject array or object
 * @param $key
 * @param mixed $default Default value if key not found in subject
 * @param string $separator Key level separator, default '/'
 *
 * @return mixed
 */
function fnGet(&$array, $key, $default = null, $separator = '/')
{
    if (($sub_key_pos = strpos($key, $separator)) === false) {
        if (is_object($array)) {
            return property_exists($array, $key) ? $array->$key : $default;
        }
        return isset($array[$key]) ? $array[$key] : $default;
    } else {
        $first_key = substr($key, 0, $sub_key_pos);
        if (is_object($array)) {
            $tmp = property_exists($array, $first_key) ? $array->$first_key : null;
        } else {
            $tmp = isset($array[$first_key]) ? $array[$first_key] : null;
        }
        return fnGet($tmp, substr($key, $sub_key_pos + 1), $default, $separator);
    }
}

/**
 * redirect to other url
 * @param $path
 */
function redirect($url)
{
    header("Location:{$url}");
    exit();
}


/**
 * easy function to handle session
 * @param $key
 * @param string $value
 * @return mixed|string
 */
function session($key, $value = '')
{
    if ('' == $value) {
        return fnGet($_SESSION,$key);
    }
    return $_SESSION[$key] = $value;
}

/**
 * easy function to handle cookie
 * @param $key
 * @param string $value
 * @return mixed|string
 */
function cookie($key, $value = '')
{
    if ('' === $value) {
        return fnGet($_COOKIE,$key);
    }
    if (null === $value) {
        return setcookie($key, $value , time()-3600 , '/');
    }
    return setcookie($key,$value, null, '/');
}

/**
 * alert by js
 * @param $msg
 * @param null $redirect
 */
function alert($msg, $redirect = null)
{
    header("Content-type: text/html; charset=utf-8");
    echo "<script>alert('{$msg}');" .(is_null($redirect) ? '' : "location.href='{$redirect}';"). "</script>";
    exit();
}

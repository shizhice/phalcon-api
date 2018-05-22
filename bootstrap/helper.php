<?php
if (! function_exists('app')) {

    /**
     * @param null $abstract
     * @author shizhice<shizhice@gmail.com>
     * @return mixed
     */
    function app($abstract = null)
    {
        if (! is_null($abstract)) {
            return \Library\App::getInstance()->{$abstract};
        }

        return \Library\App::getInstance();
    }
}

if (! function_exists('request')) {
    function request($attribute = null)
    {
        if (! is_null($attribute)) {
            return app('request')->get($attribute);
        }

        return app('request');
    }
}

if (! function_exists('endWith')) {

    /**
     * the needle is end with haystack
     * @param $haystack
     * @param $needle
     * @author shizhice<shizhice@gmail.com>
     * @return bool
     */
    function endWith($haystack, $needle)
    {
        if (substr($haystack, -strlen($needle)) === (string) $needle) {
            return true;
        }

        return false;
    }
}

if (! function_exists('filter')) {
    function filter($value, $rule)
    {
        if (is_string($rule) && strpos($rule, ',')) {
            list($rule, $param) = explode(',', $rule);
        } elseif (is_array($rule)) {
            $param = isset($rule[1]) ? $rule[1] : null;
            $rule  = $rule[0];
        } else {
            $param = null;
        }
        return false !== filter_var($value, is_int($rule) ? $rule : filter_id($rule), $param);
    }
}

if (! function_exists("domain")) {
    function domain($url){
        $arr = parse_url($url);
        $file = $arr['host'];
        $ext = substr($file,strpos($file,".")+1);
        return $ext;
    }
}

if ( ! function_exists('makeRedirectUri')) {
    function makeRedirectUri($uri, $params = [], $queryDelimiter = '?')
    {
        $uri .= (strstr($uri, $queryDelimiter) === false) ? $queryDelimiter : '&';

        return $uri . http_build_query($params);
    }
}

if (! function_exists("human_time")) {
    function human_time($date) {
        $diffTime = time() - strtotime($date);

        if ($diffTime < 60) {
            return "刚刚";
        }

        if ($diffTime < 3600) {
            return (intdiv($diffTime, 60) ?: 1)."分钟前";
        }

        if ($diffTime < 86400) {
            return (intdiv($diffTime, 3600) ?: 1)."小时前";
        }

        if ($diffTime < 2592000) {
            return (intdiv($diffTime, 86400) ?: 1)."天前";
        }

        if ($diffTime < 15552000) {
            return (intdiv($diffTime, 2592000) ?: 1)."个月前";
        }

        if ($diffTime < 31536000) {
            return "半年前";
        }

        return (intdiv($diffTime, 31536000) ?: 1)."年前";
    }
}

if (!function_exists('str_split_unicode')) {
    function str_split_unicode(string $str, int $l = 0)
    {
        $l = 0;
        if ($l > 0) {
            $ret = array();
            $len = mb_strlen($str, "UTF-8");
            for ($i = 0; $i < $len; $i += $l) {
                $ret[] = mb_substr($str, $i, $l, "UTF-8");
            }
            return $ret;
        }
        return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    }
}
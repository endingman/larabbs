<?php
// +----------------------------------------------------------------------+
// | @describe
// +----------------------------------------------------------------------+
// | Copyright (c) 2015-2017 CN,  All rights reserved.
// +----------------------------------------------------------------------+
// | @Authors: The PHP Dev LiuManMan, Web, <liumansky@126.com>.
// | @Script:
// | @date     2018-05-14 11:00:04
// +----------------------------------------------------------------------+

function route_class()
{
    /**str_replace() 函数以其他字符替换字符串中的一些字符（区分大小写）**/
    return str_replace('.', '-', Route::currentRouteName());
}

function make_excerpt($value = '', $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}

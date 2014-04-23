<?php

namespace TCB\SantasWorkshop\Helper;

class Text
{
    public static function code($text)
    {
        return preg_replace("/[^A-Za-z0-9 \-]/", '', $text);
    }
}
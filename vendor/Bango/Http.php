<?php

namespace Bango;

/**
 * Http class - define HTTP behavior.
 *
 * @package Bango
 * @author  Gabriel Moreno <gamoreno@urbe.edu.ve>
 */
class Http
{

    /**
     * Set the HTTP response status.
     *
     * @param  int  $code
     * @return void
     */
    public static function setStatus($code)
    {
        http_response_code($code);
    }
}

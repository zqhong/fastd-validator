<?php

if (!function_exists('validator')) {
    /**
     * @return Zqhong\FastdValidator\Validator
     */
    function validator()
    {
        return app()->get('validator');
    }
}

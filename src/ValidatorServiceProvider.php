<?php

namespace Zqhong\FastdValidator;

use FastD\Container\Container;
use FastD\Container\ServiceProviderInterface;

class ValidatorServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        // 表单验证类
        $container['validator'] = new Validator();
    }
}

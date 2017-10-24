<?php

namespace Config\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ConfigUserBundle extends Bundle
{

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataUserBundle';
    }
}

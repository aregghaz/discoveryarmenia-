<?php

namespace Config\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ConfigAdminBundle extends Bundle
{

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataAdminBundle';
    }
}

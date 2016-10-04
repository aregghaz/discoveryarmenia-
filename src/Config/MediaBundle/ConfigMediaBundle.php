<?php

namespace Config\MediaBundle;

use Config\MediaBundle\Lib\FileManager;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ConfigMediaBundle extends Bundle
{
    public function boot()
    {
        // Set some static globals
        FileManager::setUploadDir($this->container->getParameter('config_media.upload_dir'));
        
        FileManager::setCropImageSettings($this->container->getParameter('config_media.contexts'));
        
        FileManager::setExtensions($this->container->getParameter('config_media.extensions'));
        
        FileManager::setMimeTypes($this->container->getParameter('config_media.mime_types'));
        
        FileManager::setMaxUploadSize($this->container->getParameter('config_media.max_upload_size'));
    }
}

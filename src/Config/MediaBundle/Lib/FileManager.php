<?php

namespace Config\MediaBundle\Lib;


class FileManager
{
    protected static $uploadDir;
    
    protected static $contexts;
  
    protected static $extensions;
    
    protected static $mime_types;
    
    protected static $max_upload_size;
    
    public static function setUploadDir($dir)
    {
        self::$uploadDir = $dir;
    }

    public static function getUploadDir()
    {
        return self::$uploadDir;
    }
    
    public static function setCropImageSettings($contexts)
    {
        self::$contexts = $contexts;
    }
    public static function getCropImageSettings()
    {
        return self::$contexts;
    }
    
    public static function setExtensions($extensions)
    {
        self::$extensions = $extensions;
    }    
    public static function getExtensions()
    {
        return self::$extensions;
    }
    
    public static function setMimeTypes($mime_types)
    {
        self::$mime_types = $mime_types;
    }
    public static function getMimeTypes()
    {
        return self::$mime_types;
    }
    
    public static function setMaxUploadSize($max_upload_size)
    {
        self::$max_upload_size = $max_upload_size;
    }
    public static function getMaxUploadSize()
    {
        return self::$max_upload_size;
    }
}
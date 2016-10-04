<?php

namespace Config\MediaBundle\Model;


use Config\MediaBundle\Lib\FileManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class File extends Assert\File
{
    
    public $file;

    protected $temp;

    protected $file_icons;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    protected function getFileIcons()
    {
        $this->file_icons = array(
            'pdf' => 'bundles/configmedia/images/icons/pdf.svg',
            'docx' => 'bundles/configmedia/images/icons/doc.svg',
            'jpg' => 'bundles/configmedia/images/icons/jpg.svg',
            'JPG' => 'bundles/configmedia/images/icons/jpg.svg',
            'jpeg' => 'bundles/configmedia/images/icons/jpg.svg',
            'png' => 'bundles/configmedia/images/icons/png.svg',
            'gif' => 'bundles/configmedia/images/icons/gif.svg',
            'mp3' => 'bundles/configmedia/images/icons/mp3.svg',
            'mp4' => 'bundles/configmedia/images/icons/mp4.svg',
            'wmv' => 'bundles/configmedia/images/icons/wmv.svg',
            'xls' => 'bundles/configmedia/images/icons/xls.svg',
            'zip' => 'bundles/configmedia/images/icons/zip.svg'
        );

        return $this->file_icons;
    }

}
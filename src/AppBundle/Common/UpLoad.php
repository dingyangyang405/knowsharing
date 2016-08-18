<?php

namespace AppBundle\Common;

use Symfony\Component\Filesystem\Filesystem;

class UpLoad
{
    protected $file;

    public function __construct($file)
    {   
        $this->file = $file;
    }

    public function moveToPath($path,$fileName)
    {
        $this->file->move($path,$fileName);

        return $fileName;
    }
}
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

    public function moveToPath($user,$title)
    {
        $fileName = $title.'-'.time();
        $Path = __DIR__.'/../../../web/files/'.$user['username'];
        $this->file->move($Path,$fileName);

        return 'files/'.$user['username'].'/'.$fileName;
    }
}
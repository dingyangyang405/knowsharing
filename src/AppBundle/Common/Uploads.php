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

    public static function moveToDirectory($userId, $oldPath = null)
    {   
        $fileSystem = new Filesystem();

        if (!empty($oldPath)) {
            $array = explode('/', $oldPath);
            $name = array_pop($array);
            $fileSystem->remove(__DIR__.'/../../../web/images/IDcard/'.$userId.'/'.$name);
        }
        
        $imgExtension = $this->file->getClientOriginalExtension();
        $imgName = time().'.'.$imgExtension;
        $newDirectory = __DIR__.'/../../../web/images/IDcard/'.$userId;
        $this->file->move($newDirectory,$imgName);

        return 'images/IDcard/'.$userId.'/'.$imgName;
    }
}
<?php

namespace Codeages\Biz\Framework\Service;

abstract class KernelAwareBaseService
{
    protected $biz;

    public function __construct($biz)
    {
        $this->biz = $biz;
    }
}

<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\Common\Message\AbstractResponse;
/**
 * Class BaseAbstractResponse
 * @package Omnipay\WechatPay\Message
 */
abstract class BaseAbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        $data = $this->getData();
        return isset($data['result_code']) && $data['result_code'] == 'SUCCESS';
    }

    public function getFailData()
    {
        $data = $this->getData();
        if ($data['result_code'] == 'FAIL') {
            return '错误码：'.$data['err_code'].'，错误原因：'.$data['err_code_des'];
        }
        return null;
    }
}
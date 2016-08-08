<?php

namespace Topxia\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class KnowledgeControllerTest extends WebTestCase
{
    function testDetail()
    {
        $client = static::createKernel();
        $crawler = $client->request('GET', '/detail/1');
        $this->assertTrue($crawler->filter('html:contains("今夜无人入睡")')->count() > 0);
    }
}
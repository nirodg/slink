<?php

namespace Dorin\Bundles\SlinkBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/slink');
    }

    public function testSuccess()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/slink/success');
    }

    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/slink/{site}');
    }

}

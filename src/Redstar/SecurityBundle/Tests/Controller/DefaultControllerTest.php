<?php

namespace Redstar\SecurityBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testLogin()
    {
        /*Authenticate */
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'Aruba!23',
        ));
        /* Then try to request the homepage */
        $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
    
}

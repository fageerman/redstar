<?php

namespace Redstar\SecurityBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testLogin()
    {
        /*User wants to submit the login form without credentials */
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', '/login');
        
        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = '';
        $form['_password'] = '';

        $crawler = $client->submit($form);
        
        $response = $crawler->filter('.error')->html();
        echo "\nUser submits the login form without credentials.\n";
        $this->assertEquals($response, 'Bad credentials.');
        
        $form['_username'] = 'admin';
        $form['_password'] = 'asdfasdf';

        $crawler = $client->submit($form);
        
        $response = $crawler->filter('.error')->html();
        echo "User submits the login with bad credentials.";
        $this->assertEquals($response, 'Bad credentials.');
        
    }
    
}

<?php

namespace Redstar\SecurityBundle\Tests\Controller;


use Liip\FunctionalTestBundle\Test\WebTestCase;
use Redstar\UserBundle\Entity\User;

class DefaultControllerTest extends WebTestCase
{
    private $fixtures;
    private $client;
    private $crawler;
    
    public function setUp()
    {   
        echo "Testing login scenario's";
        $classes = array('Redstar\SecurityBundle\Tests\Fixtures\LoadUserData');
        $this->fixtures = $this->loadFixtures($classes)->getReferenceRepository();
        $this->client = static::createClient();
        $this->client->followRedirects();
    }
    
    public function testLoginScenario()
    {
        
        //User logs in with empty credentials.
        $this->crawler = $this->client->request('GET', '/login');
        $form = $this->crawler->selectButton('Login')->form();
        $form['_username'] = '';
        $form['_password'] = '';
        $this->crawler = $this->client->submit($form);
        $response = $this->crawler->filter('.error')->html();
        $this->assertEquals($response, 'Bad credentials.');

        //User logs in with with bad credentials.
        $this->crawler = $this->client->request('GET', '/login');
        $form = $this->crawler->selectButton('Login')->form();
        $form['_username'] = 'admin';
        $form['_password'] = 'asdfasdf';
        $this->crawler = $this->client->submit($form);
        $response = $this->crawler->filter('.error')->html();
        $this->assertEquals($response, 'Bad credentials.');
        
        //User logs in with the right credentials.
        $this->crawler = $this->client->request('GET', '/login');
        $form = $this->crawler->selectButton('Login')->form();
        $form['_username'] = 'admin';
        $form['_password'] = 'admin';
        $this->crawler = $this->client->submit($form);
        $this->assertEquals($this->client->getRequest()->getPathInfo(), '/');
        
        //User logs in with the right credentials, but the account is disabled.
        $this->crawler = $this->client->request('GET', '/login');
        $form = $this->crawler->selectButton('Login')->form();
        $form['_username'] = 'user';
        $form['_password'] = 'user';
        $this->crawler = $this->client->submit($form);
        $response = $this->crawler->filter('.error')->html();
        $this->assertEquals($response, 'User account is locked.');
        
        //User logs in with the right credentials, but the account is locked.
        $this->crawler = $this->client->request('GET', '/login');
        $form = $this->crawler->selectButton('Login')->form();
        $form['_username'] = 'user';
        $form['_password'] = 'user';
        $this->crawler = $this->client->submit($form);
        $response = $this->crawler->filter('.error')->html();
        $this->assertEquals($response, 'User account is locked.');
        
        //User logs in with the right credentials but account is expired.
        $this->crawler = $this->client->request('GET', '/login');
        $form = $this->crawler->selectButton('Login')->form();
        $form['_username'] = 'testuser';
        $form['_password'] = 'test';
        $this->crawler = $this->client->submit($form);
        $response = $this->crawler->filter('.error')->html();
        $this->assertEquals($response, 'User account has expired.');
    }
}

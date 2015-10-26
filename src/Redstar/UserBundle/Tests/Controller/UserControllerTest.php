<?php

namespace Redstar\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    private $crawler;
    
    
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $this->crawler = $client->request('GET', '/user/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $this->crawler = $client->click($this->crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $this->crawler->selectButton('Create')->form(array(
            'redstar_userbundle_user[field_name]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $this->crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertTrue($this->crawler->filter('td:contains("Test")')->count() > 0);

        // Edit the entity
        $this->crawler = $client->click($this->crawler->selectLink('Edit')->link());

        $form = $this->crawler->selectButton('Edit')->form(array(
            'redstar_userbundle_user[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $this->crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertTrue($this->crawler->filter('[value="Foo"]')->count() > 0);

        // Delete the entity
        $client->submit($this->crawler->selectButton('Delete')->form());
        $this->crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }

    
}
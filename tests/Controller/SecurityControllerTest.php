<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    /**
     * Method to test the routing of a user with ROLE_USER through the home page,
     * the producers' store and the admin interface
     */
    public function testSimpleUserAccess()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $client->followRedirects();

        $link = $crawler->filter('a[href="/login"]')->link();
        $crawler = $client->click($link);

        $crawler = $client->submitForm('Connexion', [
            'email'    => 'user@email.com',
            'password' => 'password',
        ]);

        $this->assertEquals('/', $client->getRequest()->getPathInfo());
        $link = $crawler
            ->filter('a:contains("Boutique du producteur")')
            ->eq(0)
            ->link()
        ;
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/producer/profil');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/admin');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * Method to test the application with an user with the ROLE_ADMIN.
     * The administrator is moved to the admin interface, creates a new subcategory,
     * uses the search bar, and deletes the previously created item
     */
    public function testAdminAccess()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $client->followRedirects();

        $link = $crawler->filter('a[href="/login"]')->link();
        $crawler = $client->click($link);

        $crawler = $client->submitForm('Connexion', [
            'email'    => 'admin@admin.com',
            'password' => 'nY4KreT5xBT3LSRKsjYR9oiETqxA',
        ]);

        $this->assertEquals('/', $client->getRequest()->getPathInfo());
        $link = $crawler->filter('a[href="/admin"]')->link();
        $crawler = $client->click($link);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->clickLink('Liste des sous-catégories');

        $this->assertEquals('/backend/subcategory', $client->getRequest()->getPathInfo());
        $form = $crawler->selectButton("ajouter")->form();
        $form['add_subcategory[name]'] = 'John Doe was here';

        $crawler = $client->submit($form);
        $this->assertSelectorTextContains('div.alert-dismissible', 'La sous-catégorie a été créée avec succès !');

        $form = $crawler->filter('button#search_submit')->eq(0)->form();
        $form['q'] = 'John Doe was here';

        $crawler = $client->submit($form);
        $this->assertSelectorTextContains('td:nth-of-type(3)', 'John Doe was here');
        $searchRequest = $client->getRequest()->getUri();

        $form = $crawler->filter('button.delete__button')->eq(0)->form();
        $crawler = $client->submit($form);

        $crawler = $client->request('GET', $searchRequest);
        $this->assertSelectorTextContains('td[colspan="9"]', 'Aucun résultat !');
    }
}
<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    /**
     * Test if the differents routes of the MainController are accessible for
     * an anonymous user
     *
     * @dataProvider provideUrls
     */
    public function testPagesAccess($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * Test to verify the proper functioning of the contact form and associated
     * redirects
     */
    public function testContactForm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact');
        $form = $crawler->selectButton('Envoyer')->form();

        $form['contact_form[name]']    = 'John Doe';
        $form['contact_form[email]']   = 'johndoe@email.com';
        $form['contact_form[content]'] = 'Hello there !';

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());
    }

    /**
     * Check that the paths to the administration interface and the editing of a
     * producer profile are redirected to the login page as an anonymous user
     */
    public function testUnauthorizedAccess()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin');

        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();

        $homeLink = $crawler->filter('a.navbar-brand')->link();
        $crawler = $client->click($homeLink);

        $crawler = $client->request('GET', '/profil');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    /**
     * Method that returns all MainController urls.
     *
     * @return array
     */
    public function provideUrls()
    {
        return [
            ['/'],
            ['/faq'],
            ['/cgv'],
            ['/mentions-legales'],
            ['/contact'],
        ];
    }
}

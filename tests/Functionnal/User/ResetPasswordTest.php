<?php

namespace App\Tests\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

/**
 * @codeCoverageIgnore
 */
class ResetPasswordTest extends WebTestCase
{
    // exemple : email reset : http://localhost:8000/reset-password/reset/RDalwjKOOWRqhIxq5kNdQ12BKUOwMbD7Bl4R3GUb
    public function testResetPasswordRoute()
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get("router");
        $client->request('GET', $urlGenerator->generate("app_forgot_password_request"));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testResetPasswordWithValidEmail()
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get("router");

        $crawler = $client->request('GET', $urlGenerator->generate("app_forgot_password_request"));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->filter('form')->form([
            'reset_password_request_form[email]'=> 'admin@reseau-net.fr',
        ]);

        $client->submit($form);
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testResetPasswordWhitBadEmail()
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get("router");
        $crawler = $client->request('GET', $urlGenerator->generate("app_forgot_password_request"));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->filter('form')->form([
            'reset_password_request_form[email]'=> 'fail@email.fr',
        ]);

        $client->submit($form);
        $client->followRedirect();
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    public function testResetPasswordCheckEmail()
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get("router");
        $client->request('GET', $urlGenerator->generate("app_check_email"));
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testResetPasswordResetWhithoutToken()
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get("router");
        $client->request('GET', $urlGenerator->generate("app_reset_password"));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testResetPasswordResetWhithFailTokenInURL()
    {
        $client = static::createClient();
        $token = 'fail';
        $client->request('GET', '/reset-password/reset/'.$token);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function testResetPasswordResetWhithFailTokenInSession()
    {
        
        $session = new Session(new MockFileSessionStorage());
        $session->set('token','fail');
        $client = static::createClient();
        $token = 'fail';
        $client->request('GET', '/reset-password/reset/'.$token);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

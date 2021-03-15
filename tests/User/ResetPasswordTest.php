<?php

namespace App\Tests\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResetPasswordTest extends WebTestCase
{

    public function testResetPasswordRoute()
    {
        $client = static::createClient();

        $client->request('GET', '/reset-password');
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testResetPasswordWithValidEmail()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/reset-password');
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

        $crawler = $client->request('GET', '/reset-password');
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
        $client->request('GET', '/reset-password/check-email');
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testResetPasswordResetWhithoutToken()
    {
        $client = static::createClient();
        $client->request('GET', '/reset-password/reset');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testResetPasswordResetWhithFailToken()
    {
        $client = static::createClient();
        $token = 'fail';
        $client->request('GET', '/reset-password/reset/'.$token);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

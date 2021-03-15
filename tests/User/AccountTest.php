<?php

namespace App\Tests\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserAccountTest extends WebTestCase
{
    
    public function testAccountPageAsAnonymous()
    {

        $client = static::createClient();
        $client->request('GET', '/account');
        $client->followRedirect();

        // test redirection vers login

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAccountPageWithLoggedUser()
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@reseau-net.fr');
        $client->loginUser($testUser);

        $client->request('GET', '/account');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

<?php

namespace App\Tests\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UserAccountTest extends WebTestCase
{
    
    public function testAccountPageAsAnonymous()    
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get("router");
        $client->request('GET', $urlGenerator->generate("user_account"));
        $this->assertResponseRedirects('/login');
    }

    public function testAccountPageWithLoggedUser()
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get("router");

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@reseau-net.fr');
        $client->loginUser($testUser);

        $client->request('GET', $urlGenerator->generate("user_account"));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

<?php

namespace App\Tests\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserLoginTest extends WebTestCase
{

    /**
     * @dataProvider provideUrls
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
    
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function provideUrls()
    {
        return [
            ['/login'],
            ['/register'],
        ];
    }


// LOGIN
    public function testloginPageWithLoggedUser()
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get("router");
        
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@reseau-net.fr');
        $client->loginUser($testUser);

        $client->request('GET', $urlGenerator->generate("app_login"));
        $this->assertResponseRedirects($urlGenerator->generate("user_account"));
    }

    public function testloginPageWithValidData()
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get("router");

        $crawler = $client->request('GET', $urlGenerator->generate("app_login"));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->filter('form')->form([
            'email'=> 'admin@reseau-net.fr',
            'password'=> 'password',
        ]);

        $client->submit($form);
        $this->assertResponseRedirects($urlGenerator->generate("user_account"));
    }

    public function testloginPageWithBadEmail()
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get("router");

        $crawler = $client->request('GET', $urlGenerator->generate("app_login"));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->filter('form')->form([
            'email'=> 'fail@email.fr',
            'password'=> 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();

        $this->assertStringContainsString("Email could not be found.", $client->getResponse()->getContent());
    }


    public function testloginPageWithBadPassword()
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get("router");
        $crawler = $client->request('GET', $urlGenerator->generate("app_login"));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->filter('form')->form([
            'email'=> 'admin@reseau-net.fr',
            'password'=> 'failpassword',
        ]);

        $client->submit($form);
        $client->followRedirect();
        $this->assertStringContainsString("Identifiants invalides.", $client->getResponse()->getContent());
    }

    public function testloginPageWithBadCSRF()
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get("router");

        $crawler = $client->request('GET', $urlGenerator->generate("app_login"));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());


        $form = $crawler->filter('form')->form([
            'email'=> 'false@email.fr',
            'password'=> 'password',
            '_csrf_token' => 'fail'
        ]);

        $client->submit($form);
        $client->followRedirect();
        $this->assertStringContainsString("Jeton CSRF invalide.", $client->getResponse()->getContent());
    }

// LOGOUT
    public function testlogoutPage()
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get("router");
        $client->request('GET', $urlGenerator->generate("app_logout"));

        $client->followRedirect();
        $this->assertRouteSame("home");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

<?php

namespace App\Tests\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationTest extends WebTestCase
{
        
    public function testRegistrationSubmit()
    {

        $client = static::createClient();

        $crawler = $client->request('GET', '/register');

        $userRepository = static::$container->get(UserRepository::class);
        $users = $userRepository->findAll();
        $userNumber= count($users) +1;

        $form = $crawler->filter('form[name=registration_form]')->form([
            'registration_form[firstname]'=> 'user',
            'registration_form[lastname]'=> 'user',
            'registration_form[email]'=> 'user-'.$userNumber.'@reseau-net.fr',
            'registration_form[plainPassword]'=> 'password',
            'registration_form[agreeTerms]'=> 1,
        ]);

        $client->submit($form);

        $client->followRedirect(); // is not redirected if user exists

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

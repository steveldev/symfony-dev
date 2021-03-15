<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;

/**
 * @codeCoverageIgnore
 */
class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        /* Administrator */
        $user = new User();
        $user->setEmail('admin@reseau-net.fr');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'password'
        ));
        $user->setFirstname('adminfirstname');
        $user->setLastname('adminlastname');
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
        
        
        /* Users */
        for ($i = 1; $i <=5; $i++) {
            $user = new User();
            $user->setEmail('user-'.$i.'@reseau-net.fr');
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'password'
            ));
            $user->setFirstname('userfirstname');
            $user->setLastname('userlastname');
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }
        
        $manager->flush();
    }
}

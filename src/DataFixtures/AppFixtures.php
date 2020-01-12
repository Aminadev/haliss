<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
    $this->passwordEncoder = $passwordEncoder;

    }


    
    public function load(ObjectManager $manager)
    {
        $roleSupadmin = new Role();
        $roleSupadmin->setLibelle("SUP_ADMIN");
        $manager->persist($roleSupadmin);

        $roleAdmin = new Role();
        $roleAdmin->setLibelle("ADMIN");
        $manager->persist($roleAdmin);

        $roleCaissier = new Role();
        $roleCaissier->setLibelle("CAISSIER");
        $manager->persist($roleCaissier);

       $this->addReference('ROLE_SUP_ADMIN', $roleSupadmin);

       $rolesupad= $this->getReference('ROLE_SUP_ADMIN');
      
        

        $user = new User();

        $user->setUsername("amina");
        $user->setRoles(["ROLE_". $rolesupad->getLibelle()]);
        $user->setUserRole($rolesupad);
        $user->setPassword($this->passwordEncoder->encodePassword($user,'123'));
        $user->setIsActive(true);
        $manager->persist($user);



        $manager->flush();
    }

    
}

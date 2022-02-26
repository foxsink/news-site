<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        if (!$manager->getRepository(User::class)->findOneBy(['username' => 'login'])) {
            $user = new User();
            $user->setUsername('login');
            $user->setRoles(['ROLE_ADMIN']);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $manager->persist($user);
        }

        if (count($manager->getRepository(Category::class)->findAll()) === 0) {
            $category = new Category();
            $category->setName('Init Category');
            $manager->persist($category);
        }

        if (count($manager->getRepository(Post::class)->findAll()) === 0) {
            for ($i = 0; $i < 15; $i++) {
                $post = new Post();
                $post->setAnnounce($i);
                $post->setCategory($manager->getRepository(Category::class)->findOneBy(['name' => 'Init Category']));
                $post->setIsActive(true);
                $post->setText($i . " Post Text");
                $post->setTitle($i . " Post Title");
                $manager->persist($post);
            }
        }


        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use \DateTime;

use App\Entity\Post;

use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture

{

    public function load(ObjectManager $manager)
    
    {
    
        $d = new DateTime();
        
        for ($i = 1; $i < 20; $i++) {
        
            $post = new Post();

            $post->setNomPoisson('poisson n°'.$i);
            $post->setPhotoPoisson('ceci est un numéro de photo');
            $post->setTaillePoisson('120');
            $post->setPoidsPoisson('50');
            $post->setDetails('Ce poisson a été péché avec amour.');
            $post->setNomAuteurP('Nom d\'auteur');
            $post->setPrenomAuteurP('Prénom d\'auteur');
            $post->setCreatedAt($d);
            
            $manager->persist($post);
            
        }

        $manager->flush();
    }
}

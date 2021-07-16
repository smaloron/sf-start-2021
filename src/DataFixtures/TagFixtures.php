<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends Fixture
{

    public static $tags = [
        "PHP", "Symfony", "NodeJS", "SQL", "Judo", "Aviron", "Photographie"
    ];

    public function load(ObjectManager $manager)
    {
        
        foreach(self::$tags as $tagName){
            $tag = new Tag();
            $tag->setTagName($tagName);

            $this->addReference($tagName, $tag);

            $manager->persist($tag);
        }

        $manager->flush();
    }
}

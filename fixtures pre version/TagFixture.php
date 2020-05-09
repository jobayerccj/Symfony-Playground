<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Common\Persistence\ObjectManager as PersistenceObjectManager;

class TagFixture extends BaseFixture
{
    protected function loadData(PersistenceObjectManager $manager)
    {
        $this->createMany(Tag::class, 20, function(Tag $tag){
            $tag->setName($this->faker->realText(20));
        });

        $manager->flush();
    }
}

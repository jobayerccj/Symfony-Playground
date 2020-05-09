<?php

namespace App\DataFixtures;


use Doctrine\Common\Persistence\ObjectManager as PersistenceObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Exception;
use Faker\Factory;

abstract class BaseFixture extends Fixture {

    private $manager;

    /** @var Generator */
    protected $faker;

    abstract protected function loadData(PersistenceObjectManager $manager);

    public function load(PersistenceObjectManager $manager)
    {   
        $this->faker = Factory::create();

        $this->manager = $manager;
        $this->loadData($manager);
    }

    protected function createMany(string $className, int $count, callable $factory){
        for($i = 0; $i < $count; $i++){
            $entity = new $className();
            $factory($entity, $i);

            $this->manager->persist($entity);
            $this->addReference($className . '_'.$i, $entity);

            //echo json_encode($this->getReference($className . '_'.$i));
        }
    }

    public function getRandomRefence(string $className){
        if(!isset($this->referencesIndex[$className])){

            $this->referencesIndex[$className] = [];

            foreach($this->referenceRepository->getReferences() as $key => $ref){
                if(strpos($key, $className.'_') === 0){
                    $this->referencesIndex[$className][] = $key;
                }
            }

            if(empty($this->referenecesIndex[$className])){
                throw new \Exception(sprintf('can not find any references for class "%s"', $className));
            }

            $randReferenceKey = $this->faker->randomElement($this->referencesIndex[$className]);

            return $this->getReference($randReferenceKey);
        }
    }

    public function getRandomReferences(string $className, int $count){
        $references = [];

        while(count($references) < $count){
            $references[] = $this->getRandomRefence($className);
        }

        return $references;
    }
}
<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $count = 0;
        $faker = Factory::create();

        for ($j = 0; $j<5; $j++){
            for ($i = 0; $i< 10; $i++){
                $season = new Season();
                $season->setYear($faker->date('Y'));
                $season->setNumber($i);
                $season->setDescription($faker->text(255));

                $season->setProgram($this->getReference('program_' . $j));
                $manager->persist($season);

                $this->addReference('season_' . $count, $season);
                $count++;
            }
        }
        $manager->flush();


    }

    public function getDependencies()
    {
        return [
           ProgramFixtures::class
        ];
    }
}

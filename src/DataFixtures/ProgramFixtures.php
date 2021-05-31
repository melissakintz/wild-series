<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
            $faker = Faker\Factory::create();
            $program = new Program();
            $program->setTitle($faker->name());
            $program->setSummary($faker->text());
            $program->setPoster($faker->imageUrl());



            $manager->persist($program);

        $manager->flush();
    }


    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture
{
    const PROGRAMS = [
        [null, ]
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $key => $oneProgram){
            $program = new Program();
            $program->setTitle($oneProgram);
            $program->setSummary($oneProgram);
            $program->setPoster($program);



            $manager->persist($program);
        }

        $manager->flush();
    }


    public function getDependencies(): array
    {
        return [
            SeasonFixtures::class,
            CategoryFixtures::class,
        ];
    }
}

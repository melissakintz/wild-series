<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture
{
    const SEASONS = [
        [1, "c'est une description", 2020]
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::SEASONS as $key => $seasons) {
            $season = new Season();
            $season->setNumber($seasons[0]);
            $season->setDescription($seasons[1]);
            $season->setYear($seasons[2]);
            $season->setProgram(null);

            $manager->persist($season);
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

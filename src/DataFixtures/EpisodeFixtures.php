<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private $slugify;

    public function __construct(Slugify  $slugifyService)
    {
        $this->slugify = $slugifyService;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++){
            $episode = new Episode();
            $episode->setTitle($faker->text(20));
            $episode->setNumber($i);
            $episode->setSynopsis($faker->text(255));

            $episode->setSeason($this->getReference('season_' . $i));
            $episode->setSlug($this->slugify->generate($episode->getTitle()));
            $manager->persist($episode);

            $this->addReference('episode_' . $i, $episode);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class
        ];
    }
}

<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Actor;


class ActorFixtures extends Fixture
{
    public const ACTORS = [
        "Norman Reedus",
        "Andrew Lincoln",
        'Lauren Cohan',
        'Jeffrey Dean Morgan',
        'Chandler Riggs',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::ACTORS as $key => $actorName) {
            $actor = new Actor();
            $actor->setName($actorName);

            $manager->persist($actor);

            $this->addReference('actor_' . $key, $actor);
        }
        $manager->flush();
    }
}

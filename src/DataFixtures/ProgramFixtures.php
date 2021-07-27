<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    private $slugify;

    public function __construct(Slugify  $slugifyService)
    {
        $this->slugify = $slugifyService;
    }
    public const PROGRAMS = [
        ["Game of Thrones","Nine noble families fight for control over the lands of Westeros, while an ancient enemy returns after being dormant for millennia.","https://m.media-amazon.com/images/M/MV5BYTRiNDQwYzAtMzVlZS00NTI5LWJjYjUtMzkwNTUzMWMxZTllXkEyXkFqcGdeQXVyNDIzMzcwNjc@._V1_SY264_CR8,0,178,264_AL_.jpg"],
        ["The Walking Dead","Sheriff Deputy Rick Grimes wakes up from a coma to learn the world is in ruins and must lead a group of survivors to stay alive.","https://m.media-amazon.com/images/M/MV5BMTc5ZmM0OTQtNDY4MS00ZjMyLTgwYzgtOGY0Y2VlMWFmNDU0XkEyXkFqcGdeQXVyNDIzMzcwNjc@._V1_SX178_AL_.jpg"],
        ["Breaking Bad","A high school chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine in order to secure his family's future","https://m.media-amazon.com/images/M/MV5BMjhiMzgxZTctNDc1Ni00OTIxLTlhMTYtZTA3ZWFkODRkNmE2XkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_SY264_CR6,0,178,264_AL_.jpg"],
        ["Vikings","Vikings transports us to the brutal and mysterious world of Ragnar Lothbrok, a Viking warrior and farmer who yearns to explore - and raid - the distant shores across the ocean.","https://m.media-amazon.com/images/M/MV5BODk4ZjU0NDUtYjdlOS00OTljLTgwZTUtYjkyZjk1NzExZGIzXkEyXkFqcGdeQXVyMDM2NDM2MQ@@._V1_SX178_AL_.jpg"],
        ["Stranger Things","When a young boy disappears, his mother, a police chief and his friends must confront terrifying supernatural forces in order to get him back","https://m.media-amazon.com/images/M/MV5BN2ZmYjg1YmItNWQ4OC00YWM0LWE0ZDktYThjOTZiZjhhN2Q2XkEyXkFqcGdeQXVyNjgxNTQ3Mjk@._V1_SY264_CR0,0,178,264_AL_.jpg"],
    ];

    public function load(ObjectManager $manager)
    {
        $date = new \DateTime('now');
        foreach (self::PROGRAMS as $key => $programs) {
            $program = new Program();
            $program->setTitle($programs[0]);
            $program->setSummary($programs[1]);
            $program->setPoster($programs[2]);
            $program->setCategory($this->getReference('category_3'));
            $program->addActor($this->getReference('actor_2'));
            $program->setOwner($this->getReference('user_contributor'));
            $program->setUpdatedAt($date);

            $program->setSlug($this->slugify->generate($programs[0]));

            $manager->persist($program);

            $this->addReference('program_' . $key, $program);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ActorFixtures::class,
            CategoryFixtures::class,
            UserFixtures::class
        ];
    }
}

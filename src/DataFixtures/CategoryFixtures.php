<?php


namespace App\DataFixtures;


use App\Entity\Program;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use phpDocumentor\Reflection\Types\Self_;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = [
        'Action',
        'Aventure',
        'Adulte',
        'Enfant',
        'Science-Fiction',
        'Horreur'
    ];

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $categoryName){
            $category = new Category();
            $category->setName($categoryName);

            $manager->persist($category);

            $this->addReference('category_' . $key, $category);
        }

        $manager->flush();
    }
}
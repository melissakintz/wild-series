<?php


namespace App\DataFixtures;


use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use phpDocumentor\Reflection\Types\Self_;

class CategoryFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture
{
    const CATEGORIES = [
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
        }
        $manager->flush();
    }
}
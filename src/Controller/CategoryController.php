<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @Route ("/categories", name="category_")
 * @package App\Controller
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        if (!$categories){
            throw $this->createNotFoundException();
        }

        return $this->render('category/index.html.twig', ['categories' => $categories]);
    }

    /**
     * @param string $categoryName
     * @return Response
     * @Route("/{categoryName}", name="show")
     */
    public function show(string $categoryName): Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);

        if (!$category){
            //throw $this->createNotFoundException();

            $message = "Il n'y a pas de catégorie nommée " . $categoryName ;
            return $this->render('error404.html.twig', ['message' => $message]);
        }

        $programsByCategory = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => $category->getId()], ['id' => 'DESC'], 3 );

        return $this->render('/category/show.html.twig', ['category' => $category, 'programs' => $programsByCategory]);
    }
}
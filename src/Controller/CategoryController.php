<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryType;

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
     * @param Request $request
     * @return Response
     * @Route ("/new", name="new")
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            //recup the entity manager
            $entityManager = $this->getDoctrine()->getManager();
            // persist anf flush : ajout dans la base
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'The new category has been created');

            return $this->redirectToRoute('category_index');        }

        return $this->render('category/new.html.twig', ['form' => $form->createView()]);
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
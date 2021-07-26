<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $programs = $this->getDoctrine()->getRepository(Program::class) ->findAll();

        return $this->render("/index.html.twig", ['programs' => $programs, 'categories' => $categories]);
    }

    /**
     * @param Request $request
     * @Route("/lang", name="app_lang", methods={"POST"})
     */
    public function lang(Request $request): Response
    {
        $value = $request->request->get('value');
        $request->setLocale($value);
        return $this->json(['teest' => $value]);
        //return $this->redirectToRoute("app_index");
    }
}

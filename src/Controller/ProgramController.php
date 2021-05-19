<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProgramController
 * @Route ("/programs", name="program_")
 * @package App\Controller
 */

class ProgramController extends AbstractController
{
    /**
     * @Route ("/", name="index")
     * @return Response
     */
        public function index(): Response
    {
                return $this->render('program/index.html.twig', ['website' => 'Wild Series']);
    }

    /**
     * @param int $id
     * @return Response
     * @Route ("/{id}",  requirements={"id"="\d+"}, methods={"GET"}, name="show")
     */
    public function show(int $id): Response
    {
        return $this->render('program/show.html.twig', ['id' => $id]);
    }
}
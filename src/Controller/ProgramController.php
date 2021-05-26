<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Program;
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
     * Show all rows from Program’s entity
     * @Route ("/", name="index")
     * @return Response
     */
        public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();
        return $this->render('program/index.html.twig', ['programs' => $programs]);
    }

    /**
     * @param int $id
     * @return Response
     * @Route ("/{id}",  requirements={"id"="\d+"}, methods={"GET"}, name="show")
     */
    public function show(int $id): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $id]);

        if(!$program){
            //throw $this->createNotFoundException()('No program with id : '.$id.' found in program\'s table.');
            $message = 'No program with id : '.$id.' found in program\'s table.';
            return $this->render('error404.html.twig', ['message' => $message]);
        }

        return $this->render('program/show.html.twig', ['program' => $program]);
    }
}
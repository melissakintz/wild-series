<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Program;
use App\Entity\Season;
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
    //var_dump($program);die();
        return $this->render('program/show.html.twig', ['program' => $program]);
    }

    /**
     * @Route("/{programId}/seasons/{seasonId}", name="season_show")
     */
    public function showSeason(int $programId, int $seasonId): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $programId]);

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id' => $seasonId]);

        return $this->render('program/season_show.html.twig', ['season' => $season, 'program' => $program]);
    }
}
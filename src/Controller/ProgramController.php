<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\CategoryType;
use App\Form\ProgramType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * Show all rows from ProgramFixtures’s entity
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
     * @return Response
     * @Route ("/new", name="new")
     */
    public function new(Request $request): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            //recup the entity manager
            $entityManager = $this->getDoctrine()->getManager();
            // persist anf flush : ajout dans la base
            $entityManager->persist($program);
            $entityManager->flush();

            return $this->redirectToRoute('program_index');        }

        return $this->render('program/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param int $id
     * @return Response
     * @Route ("/{id}",  requirements={"id"="\d+"}, methods={"GET"}, name="show")
     */
    public function show(Program $program): Response
    {
        if(!$program){
            //throw $this->createNotFoundException()('No program with id : '.$id.' found in program\'s table.');
            $message = 'No program with id : '.$id.' found in program\'s table.';
            return $this->render('error404.html.twig', ['message' => $message]);
        }
    //var_dump($program);die();
        return $this->render('program/show.html.twig', ['program' => $program]);
    }

    /**
     * @Route("/{program}/seasons/{season}", name="season_show")
     */
    public function showSeason(Program $program, Season $season): Response
    {
        return $this->render('program/season_show.html.twig', ['season' => $season, 'program' => $program]);
    }

    /**
     * @param Program $program
     * @param Season $season
     * @param Episode $episode
     * @return Response
     * @Route ("/{program}/seasons/{season}/episodes/{episode}", name="episode_show")
     */
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', ['season' => $season, 'program' => $program, 'episode' => $episode]);

    }
}
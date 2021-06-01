<?php


namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Program;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ActorController
 * @package App\Controller
 * @Route ("/actor", name="actor_")
 */
class ActorController extends AbstractController
{
    /**
     * @return Response
     * @Route ("/", name="index")
     */
    public function index(): Response
    {
        $actors = $this->getDoctrine()
            ->getRepository(Actor::class)
            ->findAll();

        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render('actor/index.html.twig', ['actors' => $actors, 'programs' => $programs]);
    }

    /**
     * @param Actor $actor
     * @Route ("/addProgram/{actor}/program/{program}", name="addProgram")
     */
    public function addActor(Actor $actor, Program $program): Response
    {
        $actor->addProgram($program);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->render("/actor/show.html.twig", ['actor' => $actor]);
    }

    /**
     * @param Actor $actor
     * @return Response
     * @Route ("/{id}",  requirements={"id"="\d+"}, methods={"GET"}, name="show")
     */
    public function show(Actor $actor): Response
    {
        return $this->render("/actor/show.html.twig", ['actor' => $actor]);
    }
}
<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\CommentType;
use App\Form\SearchProgramFormType;
use App\Service\Slugify;
use App\Form\ProgramType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(SearchProgramFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $search = $form->getData()['search'];
            $programs = $this->getDoctrine()->getRepository(Program::class)->findLikeName($search);
        }else{
            $programs = $this->getDoctrine()
                ->getRepository(Program::class)
                ->findAll();
        }
        return $this->render('program/index.html.twig', ['programs' => $programs, 'form' => $form->createView()]);
    }

    /**
     * @param Request $request
     * @param Slugify $slugify
     * @param MailerInterface $mailer
     * @return Response
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     * @Route ("/new", name="new")
     */
    public function new(Request $request, Slugify $slugify, MailerInterface $mailer): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            //recup the entity manager
            $entityManager = $this->getDoctrine()->getManager();

            //genrate and assos slug
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);
            $program->setOwner($this->getUser());

            // persist anf flush : ajout dans la base
            $entityManager->persist($program);
            $entityManager->flush();

            $this->addFlash('success', 'The new program has been created');

            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($this->getParameter('mailer_from'))
                ->subject('Une nouvelle série vient de sortir')
                ->html($this->renderView('program/emailNewProgram.html.twig', ['program' => $program]));

            $mailer->send($email);

            return $this->redirectToRoute('program_index');        }
            return $this->render('program/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Program $program
     * @return Response
     * @Route ("/{slug}", methods={"GET"}, name="show")
     */
    public function show(Program $program): Response
    {
        if(!$program){
            //throw $this->createNotFoundException()('No program with id : '.$id.' found in program\'s table.');
            $message = 'No program with id : '.$id.' found in program\'s table.';
            return $this->render('error404.html.twig', ['message' => $message]);
        }

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
     * @param Request $request
     * @return Response
     * @Route ("/{program}/seasons/{season}/episodes/{episode}", name="episode_show")
     */
    public function showEpisode(Program $program, Season $season, Episode $episode, Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //recup the entity manager
            $entityManager = $this->getDoctrine()->getManager();

            /** @var \App\Entity\User $author */
            $author = $this->getUser();

            $comment->setAuthor($author);
            $comment->setEpisode($episode);
            // persist anf flush : ajout dans la base
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('success', 'The commentary has been created');

        }

        return $this->render('program/episode_show.html.twig', ['season' => $season, 'program' => $program, 'episode' => $episode, 'form' => $form->createView()]);

    }

    /**
     * @param Program $program
     * @return Response
     * @Route("/{slug}/edit", name="edit")
     */
    public function edit(Program $program, Request $request): Response
    {
        if (!($this->getUser() == $program->getOwner())) {
                        // If not the owner, throws a 403 Access Denied exception
            throw new AccessDeniedException('Only the owner can edit the program!');
        }

         $form = $this->createForm(ProgramType::class, $program);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()){
             $this->getDoctrine()->getManager()->flush();
             $this->addFlash('success', 'The program has been edited');
             return $this->redirectToRoute('program_index');
         }

            return $this->render('program/edit.html.twig', [
                'program' => $program,
                'form' => $form->createView(),
            ]);
    }

    /**
     * @param Program $program
     * @return Response
     * @Route("/{program}/watchlist", name="watchlist", methods={"POST", "GET"})
     */
    public function addToWatchlist(Program $program): Response
    {
        if ($this->getUser()->isInWatchlist($program)){
            $this->getUser()->removeWatchlist($program);
        }else{
            $this->getUser()->addWatchlist($program);
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->flush();

        return $this->json(['isInWatchlist' => $this->getUser()->isInWatchlist($program)]);
    }
}
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class User
 * @package App\Controller
 * @Route("/", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @return Response
     * @Route("my-profil", name="profil")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }
}
<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class MainController
{
    public function __construct(private Environment $twig)
    {
    }

    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return new Response($this->twig->render('main/index.html.twig'));
    }
}

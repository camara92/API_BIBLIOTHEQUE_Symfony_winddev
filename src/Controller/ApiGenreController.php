<?php

namespace App\Controller;

use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiGenreController extends AbstractController
{
    #[Route('/api/genres', name: 'api_genres')]
    public function listeGenre(): Response
    {
        return $this->render('api_genre/index.html.twig', [
            'controller_name' => 'ApiGenreController',
        ]);
    }
}

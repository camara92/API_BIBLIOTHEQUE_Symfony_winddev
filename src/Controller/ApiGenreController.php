<?php

namespace App\Controller;

use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

class ApiGenreController extends AbstractController
{
    #[Route('/api/genres', name: 'api_genres')]
    public function listeGenre(GenreRepository $genreRepository, Serializer $serializer): Response
    {
        $genres = $genreRepository->findAll();
        $result = $serializer->serialize($genres, 'json', [
            'groups' => 'genreListSimple'
        ]);
        // return $this->render('api_genre/index.html.twig', [
        //     'controller_name' => 'ApiGenreController',
        // ]);
        // true : permet de savoir si serialiser sinon le faire en format que l'on veut 
        return new JsonResponse($result, 200, [], true );
    }
}

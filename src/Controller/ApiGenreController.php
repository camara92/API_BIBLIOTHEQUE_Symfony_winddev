<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Repository\GenreRepository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiGenreController extends AbstractController
{
    #[Route('/api/genres', name: 'api_genres',  methods: 'GET')]
    public function listeGenre(GenreRepository $genreRepository, SerializerInterface $serializer): Response
    {
        $genres = $genreRepository->findAll();
        $result = $serializer->serialize($genres, 'json', [
            'groups' => ['listGenreFull']
        ]);
        // return $this->render('api_genre/index.html.twig', [
        //     'controller_name' => 'ApiGenreController',
        // ]);
        // true : permet de savoir si serialiser sinon le faire en format que l'on veut 
        return new JsonResponse($result, 200, [], true);
    }

    #[Route('/api/genres/{id}', name: 'api_genres_show', methods: 'GET')]
    public function ShowGenre(Genre $grenre,  SerializerInterface $serializer): Response
    {

        $result = $serializer->serialize($grenre, 'json', [
            'groups' => ['listGenreSimple']
        ]);

        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }

    #[Route('/api/genres/', name: 'api_genres_create', methods: 'POST')]
    public function CreateGenre(Request $request,  SerializerInterface $serializer,  EntityManagerInterface $manager): Response
    {

        $data = $request->getContent();
        // $genre = new Genre();
        // $serializer = $serializer->deserialize($data, Genre::class, 'json', [ 'object_to_populate' => $genre ]);
        //methode 2 : 
        $genre = $serializer->deserialize($data ,Genre::class, 'json');
        $manager->persist($genre);
        $manager->flush();
        return new JsonResponse(
            
            'Le nouveau genre a bien été crée. Merci Daouda',
            Response::HTTP_CREATED, [
            'location' => 'api/genres/' . $genre->getId()
            // renvoyer la nouvelle header 
        ], true);

        //   ['location'=>$this->generateUrl('api/genres_show', ['id'=>$genre->getId(), UrlGeneratorInterface::ABSOLUTE_URL])];


    }

    // edit 
    #[Route('/api/genres/{id}', name: 'api_genres_update', methods: 'PUT')]
    public function Edit( Genre $genre,  Request $request,  SerializerInterface $serializer,  EntityManagerInterface $manager): Response
    {

        $data = $request->getContent();
        $serializer->deserialize($data ,Genre::class, 'json', ['object_to_populate'=>$genre ]);
        $manager->persist($genre);
        $manager->flush();
        return new JsonResponse(
            
            'Le nouveau genre a bien été modifié. Merci Daouda',
            Response::HTTP_OK,[], true);

       


    }

    // edit 
    #[Route('/api/genres/{id}', name: 'api_genres_delete', methods: 'DELETE')]
    public function Delete( Genre $genre,   EntityManagerInterface $manager): Response
    {

       // $data = $request->getContent();
        $manager->remove($genre);
        $manager->flush();
        return new JsonResponse(
            
            'Le nouveau genre a bien été supprimé. Merci Daouda',
            Response::HTTP_OK,[], false);

       


    }
}

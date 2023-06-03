<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Repository\AuteurRepository;


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
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiAuteurController extends AbstractController
{
    #[Route('/api/auteurs', name: 'api_auteurs',  methods: 'GET')]
    public function listeAuteur(AuteurRepository $auteurRepository, SerializerInterface $serializer): Response
    {
        $auteurs = $auteurRepository->findAll();
        $result = $serializer->serialize($auteurs, 'json', [
            'groups' => ['listAuteurFull']
        ]);
      
        return new JsonResponse($result, 200, [], true);
    }

    #[Route('/api/auteurs/{id}', name: 'api_auteurs_show', methods: 'GET')]
    public function ShowAuteur(Auteur $grenre,  SerializerInterface $serializer): Response
    {

        $result = $serializer->serialize($grenre, 'json', [
            'groups' => ['listAuteurSimple']
        ]);

        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }

    #[Route('/api/auteurs/', name: 'api_auteurs_create', methods: 'POST')]
    public function CreateAuteur(Request $request,  SerializerInterface $serializer,  EntityManagerInterface $manager, ValidatorInterface $validator): Response
    {

        $data = $request->getContent();
        // $auteur = new Auteur();
        // $serializer = $serializer->deserialize($data, Auteur::class, 'json', [ 'object_to_populate' => $auteur ]);
        //methode 2 : 
        $auteur = $serializer->deserialize($data ,Auteur::class, 'json');
        // contrainte de validation de l'objet : 
        $errors = $validator->validate($auteur); 

        if(count($errors)){
            $errorsJson = $serializer->serialize($errors, 'json');
            return  new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST, [], true);
        }
        $manager->persist($auteur);
        $manager->flush();
        return new JsonResponse(
            
            'Le nouveau auteur a bien été crée. Merci Daouda',
            Response::HTTP_CREATED, [
            'location' => 'api/auteurs/' . $auteur->getId()
            // renvoyer la nouvelle header 
        ], true);

        //   ['location'=>$this->generateUrl('api/auteurs_show', ['id'=>$auteur->getId(), UrlGeneratorInterface::ABSOLUTE_URL])];


    }

    // edit 
    #[Route('/api/auteurs/{id}', name: 'api_auteurs_update', methods: 'PUT')]
    public function Edit( Auteur $auteur,  Request $request,  SerializerInterface $serializer,  EntityManagerInterface $manager, ValidatorInterface $validator): Response
    {

        $data = $request->getContent();
        $serializer->deserialize($data ,Auteur::class, 'json', ['object_to_populate'=>$auteur ]);
        // gestion des erreurs 
        $errors = $validator->validate($auteur); 
        if(count($errors)){
            $errorsJson = $serializer->serialize($errors, 'json');
            return  new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST, [], true);
        } 
        $manager->persist($auteur);
        $manager->flush();
        return new JsonResponse(
            
            "L'auteur a bien été modifié. Merci Daouda",
            Response::HTTP_OK,[], true);

       


    }

    #[Route('/api/auteurs/{id}', name: 'api_auteurs_delete', methods: 'DELETE')]
    public function Delete( Auteur $auteur,   EntityManagerInterface $manager): Response
    {

       // $data = $request->getContent();
       
        $manager->remove($auteur);
        $manager->flush();
        return new JsonResponse(
            
            "L'auteur a bien été supprimé. Merci Daouda",
            Response::HTTP_OK,[], false);

       


    }
}

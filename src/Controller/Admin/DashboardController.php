<?php

namespace App\Controller\Admin;

use App\Entity\Auteur;
use App\Entity\Editeur;
use App\Entity\Livre;
use App\Entity\Genre;
use App\Entity\Nationalite;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
   
    public function __construct(private AdminUrlGenerator $adminUrlGenerator){
        
        
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
       
        $url=$this->adminUrlGenerator->setController(GenreCrudController::class)
        ->generateUrl();
        return $this->redirect($url); 

    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Biblio Api' );
         
           
    }
    

    public function configureMenuItems(): iterable
    {
      
        
        yield MenuItem::linkToCrud('Genre', 'fas fa-shopping-cart', Genre::class);
        yield MenuItem::linkToCrud('Nationalité', 'fas fa-list', Nationalite::class);
        yield MenuItem::linkToCrud('Auteur', 'fas fa-tag', Auteur::class);
        yield MenuItem::linkToCrud('Editeur', 'fas fa-truck', Editeur::class);
        yield MenuItem::linkToCrud('Livre', 'fas fa-desktop', Livre::class);
       

        
    }
}
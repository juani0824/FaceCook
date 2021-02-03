<?php

namespace App\Controller\Admin;

use App\Entity\Cantine;
use App\Entity\Commentaire;
use App\Entity\Document;
use App\Entity\Publication;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\EasyAdminBundle;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()

            ->setTitle('<img src="images/loader-1.png" width: 60px; height: 60px; >Admin')
            ->setFaviconPath('images/ico.png');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addCssFile('bundles/easyadmin/css/style.css');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Accueil', 'fa fa-home', 'accueil');

        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Géstion', 'fas fa-users', User::class);
        yield MenuItem::section('Publication');
        yield MenuItem::linkToCrud('Géstion', 'fas fa-address-card', Publication::class);
        yield MenuItem::section('Commentaires');
        yield MenuItem::linkToCrud('Géstion', 'fas fa-comments', Commentaire::class);
        yield MenuItem::section('Documents');
        yield MenuItem::linkToCrud('Géstion', 'fas fa-folder-open', Document::class);
        yield MenuItem::section('Cantine Scolaire');
        yield MenuItem::linkToCrud('Géstion', 'fas fa-utensils', Cantine::class);
        yield MenuItem::section('Déconnexion');
        yield MenuItem::linkToLogout('Se déconnecter', 'fas fa-sign-out-alt');
    }
}

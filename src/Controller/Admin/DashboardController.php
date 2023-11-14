<?php

namespace App\Controller\Admin;

use App\Entity\Advertisements;
use App\Entity\CandidateAnonymous;
use App\Entity\CompanieCategories;
use App\Entity\CompaniesProfile;
use App\Entity\Contact;
use App\Entity\JobCategories;
use App\Entity\Message;
use App\Entity\User;
use App\Entity\UserProfile;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('T WEB 501 PAR 8');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('User Profile', 'fas fa-list', UserProfile::class);
        yield MenuItem::linkToCrud('Message', 'fas fa-list', Message::class);
        yield MenuItem::linkToCrud('Job Category', 'fas fa-list', JobCategories::class);
        yield MenuItem::linkToCrud('Contact', 'fas fa-list', Contact::class);
        yield MenuItem::linkToCrud('Companies Profile', 'fas fa-list', CompaniesProfile::class);
        yield MenuItem::linkToCrud('Companies Category', 'fas fa-list', CompanieCategories::class);
        yield MenuItem::linkToCrud('Candidate Anonymous', 'fas fa-list', CandidateAnonymous::class);
        yield MenuItem::linkToCrud('Advertisements', 'fas fa-list', Advertisements::class);
    }
}

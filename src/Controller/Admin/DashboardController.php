<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Media;
use App\Entity\Menu;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(ArticleCrudController::class)->generateUrl();

        return $this->redirect($url);
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
            ->setTitle('Blog');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Return to site', 'fa fa-undo', 'app_home');

        if ($this->isGranted('ROLE_ADMIN')) {

            yield MenuItem::subMenu('Menus', 'fas fa-list')->setSubItems([
                MenuItem::linkToCrud('Pages', 'fas fa-file', Menu::class),
                MenuItem::linkToCrud('Articles', 'fas fa-newspaper', Menu::class),
                MenuItem::linkToCrud('Links', 'fas fa-link', Menu::class),
                MenuItem::linkToCrud('Categories', 'fab fa-delicious', Menu::class),
            ]);
        }

        if ($this->isGranted('ROLE_ADMIN')) {

            yield MenuItem::linkToCrud('Comment', 'fas fa-comment', Comment::class);

            yield MenuItem::subMenu('Accounts', 'fas fa-user')->setSubItems([
                MenuItem::linkToCrud('All accounts', 'fas fa-user-friends', User::class),
                MenuItem::linkToCrud('Add', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),

            ]);
        }

        if ($this->isGranted('ROLE_AUTHOR')) {

            yield MenuItem::subMenu('Articles', 'fas fa-newspaper', Article::class)->setSubItems([
                MenuItem::linkToCrud('All articles', 'fas fa-newspaper', Article::class),
                MenuItem::linkToCrud('Add', 'fas fa-plus', Article::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class),
            ]);


            yield MenuItem::subMenu('Medias', 'fas fa-photo-video')->setSubItems([
                MenuItem::linkToCrud('All medias', 'fas fa-photo-video', Media::class),
                MenuItem::linkToCrud('Add', 'fas fa-plus', Media::class)->setAction(Crud::PAGE_NEW),

            ]);
        }
    }
}

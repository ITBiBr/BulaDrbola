<?php

namespace App\Controller\Admin;

use App\Entity\Aktuality;
use App\Entity\Clanky;
use App\Entity\EmailSubscription;
use App\Entity\Materialy;
use App\Entity\MaterialyKategorie;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        //return parent::index();
        return $this->render('admin/index.html.twig');
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        //return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Bula Drbola')
            ->setFaviconPath('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.3em%22 x=%220.2em%22 font-size=%2276%22 fill=%22%23fff%22>BD</text></svg>');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Web', 'fa fa-globe', $this->generateUrl('app_main'));
        yield MenuItem::linkToDashboard('Home', 'fa fa-home');

        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class)->setController(UserCrudController::class)->setPermission('ROLE_ADMIN');
        // odkaz na změnu hesla aktuálního uživatele
        $currentUserId = $this->getUser()?->getId();

        if ($currentUserId) {
            $url = $this->container->get(AdminUrlGenerator::class)
                ->setController(UserPasswordCrudController::class)
                ->setAction('edit')
                ->setEntityId($currentUserId)
                ->generateUrl();

            yield MenuItem::linkToUrl('Password change', 'fa fa-key', $url);
        }

        yield MenuItem::linkToCrud('News', 'fa fa-newspaper', Aktuality::class);
        yield MenuItem::linkToCrud('Articles', 'fa fa-newspaper', Clanky::class);
        yield MenuItem::linkToCrud('Material Categories', 'fa fa-file', MaterialyKategorie::class);
        yield MenuItem::linkToCrud('Materials', 'fa fa-file', Materialy::class);
        yield MenuItem::linkToCrud('Email Subscription', 'fa fa-envelope', EmailSubscription::class);
    }

}

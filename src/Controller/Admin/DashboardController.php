<?php

namespace App\Controller\Admin;

use App\Entity\Akce;
use App\Entity\Aktuality;
use App\Entity\BodyMapyPribeh;
use App\Entity\Clanky;
use App\Entity\Dobrovolnici;
use App\Entity\DobrovolniciAkceCiselnik;
use App\Entity\EmailSubscription;
use App\Entity\Materialy;
use App\Entity\MaterialyKategorie;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
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
            ->setFaviconPath('data:image/svg+xml,
            <svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 8578.18 2985.99%22>
                <path fill=%22%23E2B368%22 stroke=%22%23E2B368%22 d=%22M5795.98 1278.22c-57.68,17.56 -116.04,34.99 -175.95,52.03 -12.29,6.15 -24.59,12.28 -37.9,18.02 -549.51,238.38 -535.11,821 -535.91,1637.71 2511.87,-712.68 3488.38,-1412.64 3488.38,-2388.67l43.57 -597.32c-502.72,466.53 -1502.26,926.83 -2782.2,1278.22z%22/>
                <path fill=%22%23E2B368%22 stroke=%22%23E2B368%22 d=%22M2782.19 1278.22c57.68,17.56 116.07,34.99 175.95,52.03 12.32,6.15 24.62,12.28 37.93,18.02 549.51,238.38 535.11,821 535.91,1637.71 -2511.87,-712.68 -3488.41,-1412.64 -3488.41,-2388.67l-43.56 -597.32c502.74,466.53 1502.28,926.83 2782.19,1278.22z%22/>
            </svg>');
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

            yield MenuItem::linkToUrl('Password change', 'fa fa-key', $url)->setPermission('ROLE_EDITOR');
        }

        yield MenuItem::linkToCrud('News', 'fa fa-newspaper', Aktuality::class)->setPermission('ROLE_EDITOR');
        yield MenuItem::linkToCrud('Events', 'fa fa-calendar', Akce::class)->setPermission('ROLE_EDITOR');
        yield MenuItem::linkToCrud('Articles', 'fa fa-newspaper', Clanky::class)->setPermission('ROLE_EDITOR');
        yield MenuItem::linkToCrud('Material Categories', 'fa fa-file', MaterialyKategorie::class)->setPermission('ROLE_EDITOR');
        yield MenuItem::linkToCrud('Materials', 'fa fa-file', Materialy::class)->setPermission('ROLE_EDITOR');
        yield MenuItem::linkToCrud('Email Subscription', 'fa fa-envelope', EmailSubscription::class)->setPermission('ROLE_EDITOR');
        yield MenuItem::subMenu('Volunteers', 'fas fa-handshake-angle')->setSubItems([
            MenuItem::linkToCrud('Volunteers', 'fa fa-handshake-angle', Dobrovolnici::class)->setPermission('ROLE_DOBROVOLNICI'),
            MenuItem::linkToCrud('Volunteer Activities', 'fa fa-list-check', DobrovolniciAkceCiselnik::class)->setPermission('ROLE_DOBROVOLNICI')
            ]);
        yield MenuItem::linkToCrud('Story Map Points', 'fa fa-map-location', BodyMapyPribeh::class)->setPermission('ROLE_EDITOR');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addWebpackEncoreEntry('admin');
    }
}

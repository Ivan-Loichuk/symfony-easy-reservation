<?php
/**
 * AppUser: Venus
 * Date: 15/03/2020
 * Time: 11:59
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class PanelController extends AbstractController
{
    private $urlGenerator;
    private $security;

    public function __construct(Security $security, UrlGeneratorInterface $urlGenerator)
    {
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/panel/admin", name="app_panel_admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function panelAdmin()
    {
        $user = $this->security->getUser();

        return $this->render('panel/admin/base.html.twig');
    }

    /**
     * @Route("/panel", name="app_panel")
     * @IsGranted("ROLE_USER")
     */
    public function panel()
    {
        return $this->render('panel/base.html.twig');
    }
}
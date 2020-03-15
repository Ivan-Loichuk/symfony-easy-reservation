<?php
/**
 * AppUser: Venus
 * Date: 15/03/2020
 * Time: 11:59
 */

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;


class PanelController
{
    /**
     * @Route("/panel", name="app_panel")
     */
    public function login()
    {
        return $this->render('panel/base.html.twig');
    }
}
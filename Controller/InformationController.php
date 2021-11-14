<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InformationController extends AbstractController
{
    /**
     * @Route("/information", name="information")
     */
    public function index()
    {
        return $this->render('information/deliveryInfo.html.twig', [
            'controller_name' => 'InformationController',
        ]);
    }
}

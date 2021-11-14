<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Links_accountController extends AbstractController
{
    /**
     * @Route("user/product_statement", name="product_statement")
     */
    public function index()
    {
        return $this->render('links_account/product_statement.html.twig', [
            'controller_name' => 'Links_accountController',
        ]);
    }

}

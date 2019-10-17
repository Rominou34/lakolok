<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SpendingsController extends AbstractController {

    /**
     * @Route("/spendings", name="spendings")
     */
    public function index() {
        return $this->render('app/spendings/index.twig');
    }
}
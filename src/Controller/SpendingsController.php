<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SpendingsController extends AbstractController {

    public function index() {
        return $this->render('app/spendings/index.twig');
    }
}
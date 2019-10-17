<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController {

    public function index() {
        $number = random_int(0,100);

        return $this->render('index.twig', [
            'number' => $number
        ]);
    }

    public function infos() {
        return $this->render('infos.twig');
    }
}
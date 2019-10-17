<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController {

    /**
     * @Route("/", name="index")
     */
    public function index() {
        $number = random_int(0,100);

        return $this->render('index.twig', [
            'number' => $number
        ]);
    }

    /**
     * @Route("/infos", name="infos")
     */
    public function infos() {
        return $this->render('infos.twig');
    }
}
<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController {

    /**
     * @Route("/user/create", name="createUser")
     */
    public function createUser(): Response {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setLogin('test');
        $user->setPassword('toast');
        $user->setMail('test@gmail.com');
        $user->setName('Test');
        $user->setLastname('Toast');
        $user->setNickname('testou');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$user->getId());
    }

    /**
     * @Route("/api/user/{id}", name="getUserApi")
     */
    public function getApi($id) {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if(!$user) {
            throw $this->createNotFoundException('No user found for id '.$id);
        }
        return new Response('User #'.$id.' is '.$user->getName().' '.$user->getLastname());
    }
}
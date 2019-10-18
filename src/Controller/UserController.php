<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class UserController extends AbstractController {

    /** @var EntityManagerInterface */
    private $em;

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/api/user/create", name="createUser")
     */
    public function create(): Response {
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
     * @Route("/api/user/{id}", name="getUser")
     */
    public function get($id): Response {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if(!$user) {
            throw $this->createNotFoundException('No user found for id '.$id);
        }

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);

        $data = $serializer->serialize($user, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/users", name="getAllUsers")
     */
    public function getAll(): Response {
        $users = $this->em->getRepository(User::class)->findBy([], ['id' => 'DESC']);
        $data = $this->serializer->serialize($users, JsonEncoder::FORMAT);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
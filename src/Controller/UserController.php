<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Rest\Route("/api")
 */
final class UserController extends AbstractController {

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
     * @Rest\Post("/users/signup", name="signupUser")
     */
    public function signup(Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $request = $request->request;

        $user = new User();
        $user->setLogin($request->get('login'));
        $user->setPassword($request->get('password'));
        $user->setMail($request->get('mail'));
        $user->setName($request->get('name'));
        $user->setLastname($request->get('lastname'));
        $user->setNickname($request->get('nickname'));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $data = [
            'id' => $user->getId()
        ];
        $data = $this->serializer->serialize($data, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Rest\Get("/user/{id}", name="showUser")
     */
    public function showUser($id): Response {
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
     * @Rest\Get("/users", name="getAllUsers")
     */
    public function getAll(): Response {
        $users = $this->em->getRepository(User::class)->findBy([], ['id' => 'DESC']);

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoder]);

        $data = $serializer->serialize($users, JsonEncoder::FORMAT);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Rest\Get("/users/short", name="getAllUsersShort")
     */
    public function getAllShort(): Response {
        $qb = $this->em->getRepository(User::class)->createQueryBuilder('u')
            ->select('u.id, u.name, u.lastname')
            ->orderBy('u.id', 'DESC');

        $users = $qb->getQuery()->getResult();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoder]);

        $data = $serializer->serialize($users, JsonEncoder::FORMAT);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
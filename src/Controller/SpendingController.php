<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Spending;
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
 * @Rest\Route("/api/spendings")
 */
final class SpendingController extends AbstractController {
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
     *
     * @Rest\Post("/new", name="newSpending")
     */
    public function new(Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $request = $request->request;

        $spending = new Spending();
        $spending->setLib($request->get('name'));
        $spending->setAmount((float)$request->get('amount'));
        $spending->setDate(new \DateTime($request->get('date')));
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('user'));
        $spending->setUser($user);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($spending);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $data = [
            'id' => $spending->getId()
        ];
        $data = $this->serializer->serialize($data, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * 
     * @throws BadRequestHttpException
     *
     * @Rest\Get("/{id}", name="getSpending")
     */
    public function getSpending($id): Response {
        $spending = $this->getDoctrine()
            ->getRepository(Spending::class)
            ->find($id);

        if(!$spending) {
            throw $this->createNotFoundException('No spending found for id '.$id);
        }
        $data = $this->serializer->serialize($spending, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     *
     * @Rest\Get("/", name="getAll")
     */
    public function getAll(): Response {
        $spendings = $this->em->getRepository(Spending::class)->findBy([], ['date' => 'DESC']);
        $spendings_list = [];
        foreach($spendings as &$spending) {
            $user = $spending->getUser();
            $spendings_list[] = [
                'id' => $spending->getId(),
                'lib' => $spending->getLib(),
                'amount' => $spending->getAmount(),
                'date' => $spending->getDate(),
                'userid'=> $user->getId(),
                'username' => $user->getName().' '.$user->getLastname()
            ];
        }

        $data = $this->serializer->serialize($spendings_list, JsonEncoder::FORMAT);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
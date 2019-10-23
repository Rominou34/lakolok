<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Spending;
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

class SpendingController extends AbstractController {
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
     * @Route("/api/spending/create", name="createSpending")
     */
    public function create(): Response {
        $entityManager = $this->getDoctrine()->getManager();

        $spending = new Spending();
        $spending->setLib('test');
        $spending->setAmount(rand(0,250));
        $user = $this->getDoctrine()->getRepository(User::class)->find(1);
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
     * @Route("/api/spending/{id}", name="getSpending")
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
     * @Route("/api/spendings", name="getAllSpendings")
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
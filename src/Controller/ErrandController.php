<?php

namespace App\Controller;

use App\Entity\Errand;
use App\Entity\ErrandItem;
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
 * @Rest\Route("/api/errands")
 */
final class ErrandController extends AbstractController {
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
     * @Rest\Post("/new", name="newErrand")
     */
    public function new(Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $request = $request->request;

        $errand = new Errand();
        $errand->setName($request->get('name'));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($errand);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        // We serialize the spending while avoiding circular references
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoder]);

        // We get the id and the full name of the user
        $data = [
            'errand' => [
                'id' => $errand->getId(),
                'name' => $errand->getName()
            ]
        ];
        $data = $serializer->serialize($data, JsonEncoder::FORMAT);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * 
     * @throws BadRequestHttpException
     *
     * @Rest\Get("/{id}", name="getErrand")
     */
    public function getErrand($id): Response {
        $errand = $this->getDoctrine()
            ->getRepository(Errand::class)
            ->find($id);

        if(!$errand) {
            throw $this->createNotFoundException('No errand found for id '.$id);
        }
        $data = $this->serializer->serialize($errand, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     *
     * @Rest\Get("/", name="getAllErrands")
     */
    public function getAllErrands(): Response {
        $errands = $this->em->getRepository(Errand::class)->findBy([], ['id' => 'DESC']);
        $errands_list = [];

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoder]);

        foreach($errands as &$errand) {
            $errands_list[] = [
                'id' => $errand->getId(),
                'name' => $errand->getName(),
                'items' => $errand->getErrandItems()
            ];
        }

        $data = $serializer->serialize($errands_list, JsonEncoder::FORMAT);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     *
     * @Rest\Post("/createItem", name="createItem")
     */
    public function createItem(Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $request = $request->request;

        $item = new ErrandItem();
        $item->setName($request->get('name'));
        $item->setBought($request->get('bought'));

        // Getting the errand from the id
        $errand = $this->getDoctrine()->getRepository(Errand::class)->find($request->get('errand'));
        $item->setErrand($errand);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($item);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        // We serialize the spending while avoiding circular references
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoder]);

        // We get the id and the full name of the user
        $data = [
            'item' => [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'errand' => $item->getErrand()->getId()
            ]
        ];
        $data = $serializer->serialize($data, JsonEncoder::FORMAT);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
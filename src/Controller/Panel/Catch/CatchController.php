<?php

namespace App\Controller\Panel\Catch;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\CatchLocation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

final class CatchController extends AbstractController
{

    #[Route('/api/location/create', name: 'api_location_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em, ): JsonResponse
    {
    $data = json_decode($request->getContent(), true);

        if (!isset($data['name'], $data['lat'], $data['lng'])) {
            return new JsonResponse(['error' => 'Brakuje danych.'], 400);
        }

        try {
            $location = new CatchLocation();
            $location->setName($data['name']);
            $location->setLat((float) $data['lat']);
            $location->setLng((float) $data['lng']);

            $em->persist($location);
            $em->flush();

            return $this->json([
                'id' => $location->getId(),
                'name' => $location->getName(),
                'lat' => $location->getLat(),
                'lng' => $location->getLng(),
            ]);
        } catch (\Throwable $e) {
            return new JsonResponse([
                'error' => 'Błąd: ' . $e->getMessage()
            ], 500);
        }
    }

    #[Route('/catch/new', name: 'app_catch_new')]
    public function new(
        ParameterBagInterface $params,
        Request $request,
        FormFactoryInterface $formFactory
    ): Response {
        $form = $formFactory->createBuilder()
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Podaj nazwę łowiska'],
            ])
            ->add('submit', SubmitType::class, ['label' => 'Zapisz'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // tu możesz coś zrobić z $data['name']
        }

        return $this->render('panel/catch/new.html.twig', [
            'form' => $form->createView(),
            'google_maps_key' => $params->get('google_maps_key'),
            'google_drive_key' => $params->get('google_drive_key'),
            'locations_file_id' => $params->get('locations_file_id'),
        ]);
    }
}
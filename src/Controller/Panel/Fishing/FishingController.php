<?php

namespace App\Controller\Panel\Fishing;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Fishing;

final class FishingController extends AbstractController
{
    #[Route('/fishing/new', name: 'app_fishing_new')]
    public function new(
        ParameterBagInterface $params,
        Request $request,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $em
    ): Response {
        $form = $formFactory->createBuilder()
            ->add('location_name', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Location name'],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $this->getUser();

            $fishing = new Fishing();
            $userId = $user->getUserIdentifier();

            $fishing->setUserId((int)$userId);
            $fishing->setLocationName((string) $data['location_name']);
            $fishing->setStartedAt(new \DateTimeImmutable());
            $fishing->setActive(1);

            $em->persist($fishing);
            $em->flush();
            return $this->redirectToRoute('app_panel');
        }

        return $this->render('panel/fishing/new.html.twig', [
            'fishingForm' => $form->createView(),
            'google_maps_key' => $params->get('google_maps_key'),
            'google_drive_key' => $params->get('google_drive_key'),
            'locations_file_id' => $params->get('locations_file_id'),
        ]);
    }
}
<?php

namespace App\Controller\Panel\Catch;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CatchController extends AbstractController
{
/*         #[Route('/api/locations', name: 'api_locations')]
    public function locations(LocationRepository $repo): JsonResponse
    {
        $locations = $repo->findAll();

        $data = array_map(fn($loc) => [
            'id' => $loc->getId(),
            'name' => $loc->getName(),
            'district' => $loc->getDistrict(),
            'lat' => $loc->getLatitude(),   // musisz mieć latitude/longitude w tabeli!
            'lng' => $loc->getLongitude(),
        ], $locations);

        return $this->json($data);
    } */

    #[Route('/catch/new', name: 'app_catch_new')]
    public function new(): Response
    {
/*         $catch = new Catch();
        $catch->setStartedAt(new \DateTimeImmutable());
        $catch->setActive(true);
        $catch->setUser($this->getUser());

        $form = $this->createForm(CatchType::class, $catch);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($catch);
            $em->flush();

            return $this->redirectToRoute('app_panel_catch_show', [
                'id' => $catch->getId(),
            ]);
        } */
        return $this->render('panel/catch/new.html.twig', [
            'controller_name' => 'CatchController',
        ]);
        return $this->render('panel/catch/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}

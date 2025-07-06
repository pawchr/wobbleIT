<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\FishingRepository;

#[IsGranted('ROLE_USER')]
class PanelController extends AbstractController
{
    #[Route('/panel', name: 'app_panel')]
    public function index(FishingRepository $fishingRepository): Response
    {
        $userId = $this->getUser()->getUserIdentifier();

        $activeFishing = $fishingRepository->findOneBy([
            'user_id' => $userId,
            'ended_at' => null,
            'active' => 1
        ]);
        return $this->render('panel/index.html.twig', [
            'user' => $this->getUser(),
            'activeFishing' => $activeFishing,
        ]);
    }
}
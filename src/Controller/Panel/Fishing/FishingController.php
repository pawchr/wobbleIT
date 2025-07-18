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
use App\Entity\Fish;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class FishingController extends AbstractController
{
    public function __construct(
        private ParameterBagInterface $params,
        private FormFactoryInterface $formFactory,
        private EntityManagerInterface $em
    ){}
    #[Route('/fishing/new', name: 'app_fishing_new')]
    public function new(Request $request): Response {
        $form = $this->formFactory->createBuilder()
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

            $this->em->persist($fishing);
            $this->em->flush();
            return $this->redirectToRoute('app_panel');
        }

        return $this->render('panel/fishing/new.html.twig', [
            'fishingForm' => $form->createView(),
            'google_maps_key' => $this->params->get('google_maps_key'),
            'google_drive_key' => $this->params->get('google_drive_key'),
            'locations_file_id' => $this->params->get('locations_file_id'),
        ]);
    }

    #[Route('/fishing/end', name: 'app_fishing_end')]
    public function end(){
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to end fishing.');
        }

        $activeFishing = $this->em->getRepository(Fishing::class)->findOneBy(['active' => true]);
        if (!$activeFishing) {
            $this->addFlash('warning', 'No active fishing session found.');
            return $this->redirectToRoute('app_panel');
        }

        $activeFishing->setActive(false);
        $activeFishing->setEndedAt(new \DateTimeImmutable());

        $this->em->persist($activeFishing);
        $this->em->flush();
        return $this->redirectToRoute('app_panel');
    }

    #[Route('/fishing/manage', name: 'app_fishing_manage')]
    public function manage(){
        
        $user = $this->getUser();
        $activeFishing = $this->em->getRepository(Fishing::class)->findOneBy([
            'active' => 1,
            'user_id' => $user
        ]);

        if (!$activeFishing) {
            $this->addFlash('warning', 'No active fishing session found.');
            return $this->redirectToRoute('app_panel');
        }

        $allFish = $this->em->getRepository(Fish::class)->findBy(['fishing' => $activeFishing]);

        $deleteForms = [];
        foreach ($allFish as $fish) {
        $deleteForms[$fish->getId()] = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_fish_delete', ['id' => $fish->getId()]))
            ->setMethod('POST')
            ->getForm()
            ->createView();
        }

        return $this->render('panel/fishing/manage.html.twig', [
            'allFish' => $allFish,
            'deleteForms' => $deleteForms,
        ]);


        $this->em->persist($activeFishing);
        $this->em->flush();
        return $this->redirectToRoute('app_panel');
    }
}
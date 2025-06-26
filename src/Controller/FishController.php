<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Fish;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Fishing;

final class FishController extends AbstractController
{
    #[Route('/fish/add', name:'app_fish_add')]
    public function add(
        FormFactoryInterface $formFactory,
        Request $request,
        EntityManagerInterface $em
    ) : Response {
            $form = $formFactory->createBuilder()
            ->add('species_id', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Species'],
            ])
            ->add('length', NumberType::class, [
                'label' => false,
                'scale' => 2,
                'attr' => ['placeholder' => 'Length'],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {   
            $activeFishing = $em->getRepository(Fishing::class)->findOneBy(['active' => true]);

            if (!$activeFishing) {
                throw $this->createNotFoundException('Start your fishing first!');
            }

            $fish = new Fish();
            $data = $form->getData();

            $fish->setFishing($activeFishing);
            $fish->setLength((float)$data['length']);
            $fish->setSpeciesId((int)$data['species_id']);

            $em->persist($fish);
            $em->flush();
            return $this->redirectToRoute('app_panel');
        }

        return $this->render('panel/fish/add.html.twig', [
            'addFishForm' => $form->createView(),
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Fish;
use App\Entity\FishSpecies;
use App\Entity\Fishing;
use App\Validator\FishValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class FishController extends AbstractController
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private EntityManagerInterface $em,
        private FishValidator $fishValidator,
    ) {}

    #[Route('/fish/add', name: 'app_fish_add')]
    public function add(Request $request): Response
    {
        $form = $this->formFactory->createBuilder()
            ->add('species', EntityType::class, [
                'class' => FishSpecies::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose species',
                'label' => false,
                'required' => true,
            ])
            ->add('length', NumberType::class, [
                'label' => false,
                'scale' => 2,
                'attr' => ['placeholder' => 'Length'],
            ])
            ->getForm();
              
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $data = $form->getData();
                $fish = new Fish();
                $fish->setLength((float) $data['length']);
                $fish->setSpecies($data['species']);
                $user = $this->getUser();
                $activeFishing = $this->em->getRepository(Fishing::class)->findOneBy([
                    'active' => 1,
                    'user_id' => $user
                ]);
                $fish->setFishing($activeFishing);
                
                if (!$activeFishing) {
                    $form->addError(new FormError('Start your fishing first!'));
                }

                $errors = $this->fishValidator->validate($fish);
                foreach ($errors as $error) {
                    $form->addError(new FormError($error));
                }

                if ($form->isValid()) {
                    $this->em->persist($fish);
                    $this->em->flush();

                    return $this->redirectToRoute('app_fishing_manage');
                }
            }

        return $this->render('panel/fish/add.html.twig', [
            'addFishForm' => $form->createView(),
        ]);
    }

    #[Route('/fish/{id}/delete', name: 'app_fish_delete', methods: ['POST'])]
    public function delete(Fish $fish, Request $request, EntityManagerInterface $em): RedirectResponse
    {

        if (!$fish) {
            $this->addFlash('danger', 'Fish not found.');
            return $this->redirectToRoute('app_fishing_manage');
        }

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_fish_delete', ['id' => $fish->getId()]))
            ->setMethod('POST')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->remove($fish);
            $this->em->flush();

            $this->addFlash('success', 'Fish deleted.');
        }

        return $this->redirectToRoute('app_fishing_manage');

    }
}

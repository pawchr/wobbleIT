<?php

namespace App\Validator;

use App\Entity\Fish;
use Doctrine\ORM\EntityManagerInterface;

class FishValidator
{
    public function __construct(private EntityManagerInterface $em ){}

    public function validate(Fish $fish): array
    {
        $errors = [];

        $species = $fish->getSpecies();
        $fishing = $fish->getFishing();
        $today = new \DateTime();
        $length = (float)$fish->getLength();
        $speciesLimit = $species->getDailyLimit();
        $fishCount = count(
            $this->em->getRepository(Fish::class)->findBy([
                'species' => $species,
                'fishing' => $fishing
            ])
        );
        
        if ($length < $species->getMinLength()) {
            $errors[] = 'Your fish is too small, release it!';
        }

        if (
            $species->getProtectionStart() <= $today &&
            $species->getProtectionEnd() >= $today
        ) {
            $errors[] = 'This fish is currently protected, release it!';
        }
        
        if ($fishCount >= $speciesLimit) {
            $errors[] = 'You have reached the limit, release it!';
        }
    
        return $errors;
    }
}

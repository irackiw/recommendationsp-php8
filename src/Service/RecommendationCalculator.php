<?php

namespace App;

use App\Entity\Rate;
use App\Entity\User;
use App\Entity\UserEuclideanDistance;
use App\Service\RecommendationCalculatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class RecommendationCalculator implements RecommendationCalculatorInterface
{
    private $rateRepository;

    private $filmRepository;

    /** @var EntityManagerInterface */
    private $enityManager;

    /**
     * @param Rate[] $user1
     * @param Rate[] $user2
     * @return UserEuclideanDistance
     */
    public function euclideanScore(array $user1Rates, array $user2Rates): UserEuclideanDistance
    {
        $squaredDiff = [];
        /** @var Rate $movie1Rate */
        foreach ($user1Rates as $movie1Rate) {
            /** @var Rate $film2Rate */
            foreach ($user2Rates as $film2Rate) {
                $squaredDiff[] = sqrt($movie1Rate->getRate());
            }
        }

        $score = 1 / (1 + sqrt(array_sum($squaredDiff)));

        $distance = new UserEuclideanDistance($user1Rates[0]->getUser(), $user2Rates[0]->getUser(), $score);
        $this->enityManager->persist($distance);
        $this->enityManager->flush();

        return $distance;

    }

    public function personScore(array $user1Rates, array $user2Rates)
    {

    }
}
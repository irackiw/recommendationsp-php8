<?php

namespace App\Service;

use App\Entity\UserEuclideanDistance;

interface RecommendationCalculatorInterface
{
    public function euclideanScore(array $user1Rates, array $user2Rates): UserEuclideanDistance;

    public function personScore(array $user1Rates, array $user2Rates);
}
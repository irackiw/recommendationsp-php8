<?php

namespace App\Controller;

use App\Entity\Rate;
use App\Form\RateType;
use App\Repository\RateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RateController extends AbstractController
{
    private RateRepository $rateRepository;

    private EntityManagerInterface $entityManager;

    public function __construct(
        RateRepository $rateRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->rateRepository = $rateRepository;
        $this->entityManager = $entityManager;
    }

    public function list(): Response
    {
        $this->rateRepository->findAll();
    }

    /**
     * @Route("/new", name="blog_list")
     */    public function new(Request $request): Response
    {
        $rate = new Rate();
        $form = $this->createForm(RateType::class, $rate);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $this->entityManager->persist($task);
            $this->entityManager->flush();

            $this->addFlash('success', 'Film added');
            return $this->redirectToRoute('task_success');
        } else {
            $this->addFlash('error', 'Validation error');
        }

        return $this->render(
            'rate/new.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

}
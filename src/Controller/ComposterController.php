<?php

namespace App\Controller;

use App\Form\ComposterType;
use App\Repository\ComposterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComposterController extends AbstractController
{
    #[Route('/composter', name: 'app_composter_list')]
    public function index(): Response
    {
        return $this->render('composter/index.html.twig', [
            'controller_name' => 'ComposterController',
        ]);
    }

    #[Route('/composter/add', name: 'app_composter_add')]
    public function addComposter(Request $request, EntityManagerInterface $entityManager, ComposterRepository $composterRepository): Response
    {
        $form = $this->createForm(ComposterType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $composter = $form->getData();
            $entityManager->persist($composter);
            $entityManager->flush();
            return $this->redirectToRoute('app_composter_add');
        }

        $composters = $composterRepository->findAll();

        return $this->render('composter/form.html.twig', [
            'form' => $form->createView(),
            'composters' => $composters,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Form\ComposterType;
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
    public function addComposter(Request $request): Response
    {
        $form = $this->createForm(ComposterType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            return $this->redirectToRoute('app_composter_list');
        }

        return $this->render('composter/form.html.twig', [
            'form' => $form
        ]);
    }
}

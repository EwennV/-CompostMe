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

    #[Route('/composter/filter', name: 'app_composter_filter')]
    public function filter(Request $request, ComposterRepository $composterRepository): Response
    {
        $ownerTypeId = $request->query->get('ownerType', '');
        $accessTypeId = $request->query->get('accessType', '');
        $fillRateId = $request->query->get('fillRate', '');

        $composters = $composterRepository->findByFilters($ownerTypeId, $accessTypeId, $fillRateId);

        $compostersData = array_map(function ($composter) {
            return [
                'id' => $composter->getId(),
                'latitude' => $composter->getLatitude(),
                'longitude' => $composter->getLongitude(),
                'contact' => $composter->getContact(),
                'ownerType' => $composter->getOwnerType() ? $composter->getOwnerType()->getName() : null,
                'accessType' => $composter->getAccessType() ? $composter->getAccessType()->getName() : null,
                'fillRate' => $composter->getFillRate() ? $composter->getFillRate()->getName() : null,
            ];
        }, $composters);

        return $this->json([
            'composters' => $compostersData,
        ]);
    }

    #[Route('/composter/edit/{id}', name: 'app_composter_edit')]
    public function edit(ComposterRepository $composterRepository, int $id): Response
    {
        $composter = $composterRepository->find($id);
        $ownerTypes = $composterRepository->getOwnerTypes();
        $accessTypes = $composterRepository->getAccessTypes();

        if (!$composter) {
            return $this->json(['message' => 'Composteur not found'], 404);
        }

        return $this->render('composter/edit.html.twig', [
            'composter' => $composter,
            'ownerTypes' => $ownerTypes,
            'accessTypes' => $accessTypes,
        ]);
    }



}

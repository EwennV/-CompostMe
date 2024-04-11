<?php

namespace App\Controller;

use App\Repository\AccessTypeRepository;
use App\Repository\FillRateTypeRepository;
use App\Repository\OwnerTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ComposterRepository;

class MapController extends AbstractController
{
    #[Route('/map', name: 'app_map')]
    public function index(ComposterRepository $composterRepository, OwnerTypeRepository $ownerTypeRepository, AccessTypeRepository $accessTypeRepository, FillRateTypeRepository $fillRateTypeRepository): Response
    {
        $composters = $composterRepository->findAll();
        $ownerTypes = $ownerTypeRepository->findAll();
        $accessTypes = $accessTypeRepository->findAll();
        $fillRateTypes = $fillRateTypeRepository->findAll();

        return $this->render('map/index.html.twig', [
            'controller_name' => 'MapController',
            'composters' => $composters,
            'ownerTypes' => $ownerTypes,
            'accessTypes' => $accessTypes,
            'fillRateTypes' => $fillRateTypes,
        ]);
    }
}

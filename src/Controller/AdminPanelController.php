<?php

namespace App\Controller;

use App\Repository\ComposterRepository;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminPanelController extends AbstractController
{
    #[Route('/panel', name: 'app_admin_panel')]
    public function index(TicketRepository $ticketRepository, ComposterRepository $composterRepository): Response
    {
        return $this->render('admin_panel/index.html.twig', [
            'controller_name' => 'AdminPanelController',
            'tickets' => $ticketRepository->findAll(),
            'composters' => $composterRepository->findAll(),
        ]);
    }

    #[Route('/panel/tickets', name: 'app_admin_panel_tickets')]
    public function tickets(TicketRepository $ticketRepository): Response
    {
        return $this->render('admin_panel/tickets/list.html.twig', [
            'tickets' => $ticketRepository->findAll(),
        ]);
    }

    #[Route('/panel/composters', name: 'app_admin_panel_composters')]
    public function composters(ComposterRepository $composterRepository): Response
    {
        return $this->render('admin_panel/composters/list.html.twig', [
            'composters' => $composterRepository->findAll(),
        ]);
    }
}

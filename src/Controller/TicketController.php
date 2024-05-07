<?php

namespace App\Controller;

use App\Form\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TicketController extends AbstractController
{
    #[Route('/ticket/create', name:"app_ticket_create")]
    public function ticketAdd(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $form = $this->createForm(TicketType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $ticket = $form->getData();

            $entityManager->persist($ticket);
            $entityManager->flush();

            $this->addFlash('success', 'Votre SOS à bien été envoyé !');

            return $this->redirectToRoute('app_ticket_create');
        }

        return $this->render('ticket/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
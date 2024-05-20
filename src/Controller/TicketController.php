<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
            /* @var \App\Entity\Ticket $ticker */
            $ticket = $form->getData();
            $ticket->setAuthorUser($this->getUser());

            $entityManager->persist($ticket);
            $entityManager->flush();

            $this->addFlash('success', 'Votre SOS à bien été envoyé !');

            return $this->redirectToRoute('app_ticket_create');
        }

        return $this->render('ticket/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/ticket/{slug}', name:"app_ticket_show")]
    public function show(
        #[MapEntity(mapping: ['slug' => 'slug'])] Ticket $ticket
    ): Response
    {
        $user = $this->getUser();

        if (($user !== $ticket->getAuthorUser()) || false === in_array("ROLE_ADMIN", $user->getRoles())) {
            throw new NotFoundHttpException();
        }

        return $this->render('admin_panel/tickets/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[Route('/ticket/{slug}/close', name:"app_ticket_close")]
    public function close(
        #[MapEntity(mapping: ['slug' => 'slug'])] Ticket $ticket,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $user = $this->getUser();

        if (($user !== $ticket->getAuthorUser()) || false === in_array("ROLE_ADMIN", $user->getRoles())) {
            throw new NotFoundHttpException();
        }

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_ticket_close', ['slug' => $ticket->getSlug()]))
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $ticket->setClosedAt(new \DateTimeImmutable());
            $ticket->setStatus(Ticket::STATUS_TERMINE);
            $entityManager->flush();

            $this->addFlash('success', 'Le ticket a bien été marqué comme terminé !');

            return $this->redirectToRoute('app_ticket_show', ['slug' => $ticket->getSlug()]);
        }

        return $this->render('components/unitedForm.html.twig', [
            'form' => $form->createView(),
            'message' => 'Êtes-vous sûr de vouloir marquer ce ticket comme terminé ?',
            'messageButton' => 'Confirmer',
        ]);
    }
}
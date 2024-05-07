<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
use App\Form\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
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
        $ticket = new Ticket();
        $ticket->setAuthorUser($this->getUser());

        $form = $this->createForm(TicketType::class, $ticket);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
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

        if (false === in_array("ROLE_ADMIN", $user->getRoles())) {
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

            return $this->redirectToRoute('app_admin_panel_tickets');
        }

        return $this->render('components/unitedForm.html.twig', [
            'form' => $form->createView(),
            'message' => 'Êtes-vous sûr de vouloir marquer ce ticket comme terminé ?',
            'messageButton' => 'Confirmer',
        ]);
    }
    #[Route('/ticket/{slug}/status/change', name:"app_ticket_status_change")]
    public function changeStatus(
        #[MapEntity(mapping: ['slug' => 'slug'])] Ticket $ticket,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response
    {
        if (false === in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            throw new NotFoundHttpException();
        }

        $form = $this->createFormBuilder($ticket)
            ->setAction($this->generateUrl('app_ticket_status_change', ['slug' => $ticket->getSlug()]))
            ->add('status', ChoiceType::class, [
                'choices' => [
                    Ticket::STATUS_EN_ATTENTE => Ticket::STATUS_EN_ATTENTE,
                    Ticket::STATUS_EN_COURS => Ticket::STATUS_EN_COURS,
                    Ticket::STATUS_TERMINE => Ticket::STATUS_TERMINE,
                ],
                'data' => $ticket->getStatus()
            ])
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Status du ticket modifié !');

            return $this->redirectToRoute('app_ticket_show', ['slug' => $ticket->getSlug()]);
        }

        return $this->render('components/unitedForm.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/ticket/{slug}/responsable/change', name:'app_ticket_responsable_change')]
    public function changeResponsable(
        #[MapEntity(mapping: ['slug' => 'slug'])] Ticket $ticket,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response
    {
        if (false === in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            throw new NotFoundHttpException();
        }

        $form = $this->createFormBuilder($ticket)
            ->setAction($this->generateUrl('app_ticket_responsable_change', ['slug' => $ticket->getSlug()]))
            ->add('responsableUser', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'label' => 'Responsable'
            ])
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Responsable du ticket mis à jour !');

            return $this->redirectToRoute('app_ticket_show', ['slug' => $ticket->getSlug()]);
        }

        return $this->render('components/unitedForm.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/ticket/{slug}/delete', name:'app_ticket_delete')]
    public function deleteTicket(
        #[MapEntity(mapping: ['slug' => 'slug'])] Ticket $ticket,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response
    {
        if (false === in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            throw new NotFoundHttpException();
        }

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_ticket_delete', ['slug' => $ticket->getSlug()]))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $entityManager->remove($ticket);
            $entityManager->flush();

            $this->addFlash('success', 'Ticket supprimé !');

            return $this->redirectToRoute('app_admin_panel_tickets');
        }

        return $this->render('components/unitedForm.html.twig', [
            'form' => $form,
            'isDeleteForm' => true
        ]);
    }
}

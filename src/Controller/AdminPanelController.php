<?php

namespace App\Controller;

use App\Entity\FillRateType;
use App\Form\FillRateTypeType;
use App\Repository\ComposterRepository;
use App\Repository\FillRateTypeRepository;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    #[Route('/panel/parametres', name: 'app_admin_panel_settings')]
    public function settings(
        FillRateTypeRepository $fillRateTypeRepository
    ): Response
    {
        $fillRates = $fillRateTypeRepository->findAll();

        return $this->render('admin_panel/settings.html.twig', [
            'fillRates' => $fillRates
        ]);
    }

    #[Route('/panel/fillrate/add', name: 'app_admin_panel_fillrate_add')]
    public function addFillRateType(
        Request $request,
        EntityManagerInterface $entityManager
    ): mixed
    {
        $form = $this->createForm(FillRateTypeType::class, null, [
            'action' => $this->generateUrl('app_admin_panel_fillrate_add'),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fillRateType = $form->getData();

            $entityManager->persist($fillRateType);
            $entityManager->flush();

            $this->addFlash('success', 'Taux de remplissage ajouté avec succès !');

            return $this->redirectToRoute('app_admin_panel_settings');
        }

        return $this->render('components/unitedForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/panel/fillrate/edit/{fill_rate_id}', name: 'app_admin_panel_fillrate_edit')]
    public function editFillRateType(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(mapping: ['fill_rate_id' => 'id'])] FillRateType $fillRateType
    )
    {
        $form = $this->createForm(FillRateTypeType::class, $fillRateType, [
            'action' => $this->generateUrl('app_admin_panel_fillrate_edit', ['fill_rate_id' => $fillRateType->getId()]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fillRateType = $form->getData();

            $entityManager->flush();

            $this->addFlash('success', 'Taux de remplissage modifié avec succès !');

            return $this->redirectToRoute('app_admin_panel_settings');
        }

        return $this->render('components/unitedForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

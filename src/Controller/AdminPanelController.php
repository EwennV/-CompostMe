<?php

namespace App\Controller;

use App\Repository\ComposterRepository;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\AccessType;
use App\Entity\FillRateType;
use App\Entity\OwnerType;
use App\Entity\User;
use App\Form\AccessTypeType;
use App\Form\FillRateTypeType;
use App\Form\OwnerTypeType;
use App\Form\UserType;
use App\Repository\AccessTypeRepository;
use App\Repository\FillRateTypeRepository;
use App\Repository\OwnerTypeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminPanelController extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
    ) {
        $this->passwordHasher = $passwordHasher;
    }

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
        FillRateTypeRepository $fillRateTypeRepository,
        AccessTypeRepository $accessTypeRepository,
        OwnerTypeRepository $ownerTypeRepository,
    ): Response {
        $fillRates = $fillRateTypeRepository->findAll();
        $accessType = $accessTypeRepository->findAll();
        $ownerTypes = $ownerTypeRepository->findAll();

        return $this->render('admin_panel/settings.html.twig', [
            'fillRates' => $fillRates,
            'accessTypes' => $accessType,
            'ownerTypes' => $ownerTypes,
        ]);
    }

    #[Route('/panel/fillrate/add', name: 'app_admin_panel_fillrate_add')]
    public function addFillRateType(
        Request $request,
        EntityManagerInterface $entityManager
    ): mixed {
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
    ) {
        $form = $this->createForm(FillRateTypeType::class, $fillRateType, [
            'action' => $this->generateUrl('app_admin_panel_fillrate_edit', ['fill_rate_id' => $fillRateType->getId()]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            $this->addFlash('success', 'Taux de remplissage modifié avec succès !');

            return $this->redirectToRoute('app_admin_panel_settings');
        }

        return $this->render('components/unitedForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/panel/fillrate/delete/{fill_rate_id}', name: 'app_admin_panel_fillrate_delete')]
    public function deleteFillRateType(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(mapping: ['fill_rate_id' => 'id'])] FillRateType $fillRateType
    ) {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_admin_panel_fillrate_delete', ['fill_rate_id' => $fillRateType->getId()]))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($fillRateType);
            $entityManager->flush();

            $this->addFlash('success', 'Taux de remplissage supprimé avec succès !');

            return $this->redirectToRoute('app_admin_panel_settings');
        }

        return $this->render('components/unitedForm.html.twig', [
            'isDeleteForm' => true,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/panel/accesstype/add', name: 'app_admin_panel_accesstype_add')]
    public function addAccessType(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(AccessTypeType::class, null, [
            'action' => $this->generateUrl('app_admin_panel_accesstype_add'),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accessType = $form->getData();

            $entityManager->persist($accessType);
            $entityManager->flush();

            $this->addFlash('success', 'Type d\'accès ajouté avec succès !');

            return $this->redirectToRoute('app_admin_panel_settings');
        }

        return $this->render('components/unitedForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/panel/accesstype/edit/{access_type_id}', name: 'app_admin_panel_accesstype_edit')]
    public function editAccessType(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(mapping: ['access_type_id' => 'id'])] AccessType $accessType
    ): Response {
        $form = $this->createForm(AccessTypeType::class, $accessType, [
            'action' => $this->generateUrl('app_admin_panel_accesstype_edit', ['access_type_id' => $accessType->getId()]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accessType = $form->getData();

            $entityManager->flush();

            $this->addFlash('success', 'Type d\'accès modifié avec succès !');

            return $this->redirectToRoute('app_admin_panel_settings');
        }

        return $this->render('components/unitedForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/panel/accesstype/delete/{access_type_id}', name: 'app_admin_panel_accesstype_delete')]
    public function deleteAccessType(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(mapping: ['access_type_id' => 'id'])] AccessType $accessType
    ): Response {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_admin_panel_accesstype_delete', ['access_type_id' => $accessType->getId()]))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($accessType);
            $entityManager->flush();

            $this->addFlash('success', 'Type d\'accès supprimé avec succès !');

            return $this->redirectToRoute('app_admin_panel_settings');
        }

        return $this->render('components/unitedForm.html.twig', [
            'isDeleteForm' => true,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/panel/ownertype/add', name: 'app_admin_panel_ownertype_add')]
    public function addOwnerType(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(OwnerTypeType::class, null, [
            'action' => $this->generateUrl('app_admin_panel_ownertype_add'),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ownerType = $form->getData();

            $entityManager->persist($ownerType);
            $entityManager->flush();

            $this->addFlash('success', 'Type de propriétaire ajouté avec succès !');

            return $this->redirectToRoute('app_admin_panel_settings');
        }

        return $this->render('components/unitedForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/panel/ownertype/edit/{owner_type_id}', name: 'app_admin_panel_ownertype_edit')]
    public function editOwnerType(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(mapping: ['owner_type_id' => 'id'])] OwnerType $ownerType
    ): Response {
        $form = $this->createForm(OwnerTypeType::class, $ownerType, [
            'action' => $this->generateUrl('app_admin_panel_ownertype_edit', ['owner_type_id' => $ownerType->getId()]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Type de propriétaire modifié avec succès !');

            return $this->redirectToRoute('app_admin_panel_settings');
        }

        return $this->render('components/unitedForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/panel/ownertype/delete/{owner_type_id}', name: 'app_admin_panel_ownertype_delete')]
    public function deleteOwnerType(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(mapping: ['owner_type_id' => 'id'])] OwnerType $ownerType
    ): Response {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_admin_panel_ownertype_delete', ['owner_type_id' => $ownerType->getId()]))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($ownerType);
            $entityManager->flush();

            $this->addFlash('success', 'Type de propriétaire supprimé avec succès !');

            return $this->redirectToRoute('app_admin_panel_settings');
        }

        return $this->render('components/unitedForm.html.twig', [
            'isDeleteForm' => true,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/panel/users', name: 'app_admin_panel_users')]
    public function listUsers(
        UserRepository $userRepository
    ): Response {
        $users = $userRepository->findAll();

        return $this->render('admin_panel/users/list.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/panel/users/add', name: 'app_admin_panel_users_add')]
    public function addUser(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $form = $this->createForm(UserType::class, null, [
            'action' => $this->generateUrl('app_admin_panel_users_add'),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $user = $form->getData();

            $plainPassword = $user->getPassword();

            $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);

            $user->setPassword($hashedPassword);
            $user->setVerified(true);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur créé avec succès !');

            return $this->redirectToRoute('app_admin_panel_users');
        }

        return $this->render('components/unitedForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/panel/users/edit/{user_id}', name: 'app_admin_panel_users_edit')]
    public function editUser(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(mapping: ['user_id' => 'id'])] User $user
    ): Response {
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('app_admin_panel_users_edit', ['user_id' => $user->getId()]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur modifié avec succès !');

            return $this->redirectToRoute('app_admin_panel_users');
        }

        return $this->render('components/unitedForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/panel/users/delete/{user_id}', name: 'app_admin_panel_users_delete')]
    public function deleteUser(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(mapping: ['user_id' => 'id'])] User $user
    ): Response {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_admin_panel_users_delete', ['user_id' => $user->getId()]))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid() and $user !== $this->getUser()) {
            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur supprimé avec succès !');

            return $this->redirectToRoute('app_admin_panel_users');
        }

        return $this->render('components/unitedForm.html.twig', [
            'isDeleteForm' => true,
            'form' => $form->createView(),
        ]);
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Admin\AdminUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/users", name="admin_user_index")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository, PaginatorInterface $paginator, Request $request)
    {
        $paginatedUsers = $paginator->paginate(
            $userRepository->findAllUsers(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/user/index.html.twig', [
            'activeMenu' => 'user',
            'users' => $paginatedUsers
        ]);
    }

    /**
     * Permet de modifier un utlisateur
     *
     * @Route("/admin/users/{id}/edit", name="admin_user_edit")
     *
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     *
     * @return Response
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(AdminUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'utilisateur numéro <strong>{$user->getId()}</strong> a bien été modifié !"
            );
        }

        return $this->render('admin/user/edit.html.twig', [
            'activeMenu' => 'user',
            'user'       => $user,
            'form'       => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer un commentaire
     *
     * @Route("/admin/users/{id}/delete", name="admin_user_delete")
     *
     * @param User $user
     * @param EntityManagerInterface $manager
     *
     * @return RedirectResponse
     */
    public function delete(User $user, EntityManagerInterface $manager)
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'utilisateur a bien été supprimé !"
        );

        return $this->redirectToRoute('admin_user_index');
    }

}

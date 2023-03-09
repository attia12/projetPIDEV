<?php

namespace App\Controller;

use App\Entity\Coment;
use App\Form\ComentType;
use App\Repository\ComentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Seria1izer\Annotation\Groups;

#[Route('/coment')]
class ComentController extends AbstractController
{
    #[Route('/', name: 'app_coment_index', methods: ['GET'])]
    public function index(ComentRepository $comentRepository): Response
    {
        return $this->render('coment/index.html.twig', [
            'coments' => $comentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_coment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ComentRepository $comentRepository): Response
    {
        $coment = new Coment();
        $form = $this->createForm(ComentType::class, $coment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comentRepository->save($coment, true);

            return $this->redirectToRoute('app_coment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('coment/new.html.twig', [
            'coment' => $coment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_coment_show', methods: ['GET'])]
    public function show(Coment $coment): Response
    {
        return $this->render('coment/show.html.twig', [
            'coment' => $coment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_coment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Coment $coment, ComentRepository $comentRepository): Response
    {
        $form = $this->createForm(ComentType::class, $coment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comentRepository->save($coment, true);

            return $this->redirectToRoute('app_coment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('coment/edit.html.twig', [
            'coment' => $coment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_coment_delete', methods: ['POST'])]
    public function delete(Request $request, Coment $coment, ComentRepository $comentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coment->getId(), $request->request->get('_token'))) {
            $comentRepository->remove($coment, true);
        }

        return $this->redirectToRoute('app_coment_index', [], Response::HTTP_SEE_OTHER);
    }
}

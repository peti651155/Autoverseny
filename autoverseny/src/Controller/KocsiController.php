<?php

namespace App\Controller;

use App\Entity\Auto;
use App\Form\AutoType;
use App\Repository\AutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/kocsi')]
class KocsiController extends AbstractController
{
    #[Route('/', name: 'app_kocsi_index', methods: ['GET'])]
    public function index(AutoRepository $autoRepository): Response
    {
        return $this->render('kocsi/index.html.twig', [
            'autos' => $autoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_kocsi_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $auto = new Auto();
        $form = $this->createForm(AutoType::class, $auto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($auto);
            $entityManager->flush();

            return $this->redirectToRoute('app_kocsi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('kocsi/new.html.twig', [
            'auto' => $auto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_kocsi_show', methods: ['GET'])]
    public function show(Auto $auto): Response
    {
        return $this->render('kocsi/show.html.twig', [
            'auto' => $auto,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_kocsi_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Auto $auto, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AutoType::class, $auto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_kocsi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('kocsi/edit.html.twig', [
            'auto' => $auto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_kocsi_delete', methods: ['POST'])]
    public function delete(Request $request, Auto $auto, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$auto->getId(), $request->request->get('_token'))) {
            $entityManager->remove($auto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_kocsi_index', [], Response::HTTP_SEE_OTHER);
    }
}

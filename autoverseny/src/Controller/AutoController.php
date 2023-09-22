<?php

namespace App\Controller;

use App\Entity\Auto;
use App\Repository\AutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class AutoController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/auto", name="app_auto")
     */
    public function index(AutoRepository $autoRepository): Response
    {
        $autos = $autoRepository->findNotDeleted();
        return $this->render('auto/index.html.twig', ['autos' => $autos]);
    }

    /**
     * @Route("/auto/{id}/soft-delete", name="auto_soft_delete", methods={"GET"})
     */
    public function softDelete(int $id, AutoRepository $autoRepository): Response
    {
        $auto = $autoRepository->find($id);

        if (!$auto) {
            throw $this->createNotFoundException('The auto does not exist');
        }

        $auto->setDeletedAt(new \DateTime()); 
        $this->entityManager->persist($auto);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_auto');
    }
    
    /**
     * @Route("/auto/{id}/edit-inline", name="auto_edit_inline", methods={"POST"})
     */
    public function editInline(int $id, Request $request, AutoRepository $autoRepository): Response
    {
        $auto = $autoRepository->find($id);

        if (!$auto) {
            return new JsonResponse(['success' => false, 'message' => 'Auto not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        
        // Itt kiegészítve az Auto entitás többi adatával:
        $auto->setModel($data['model']);
        $auto->setManufactureYear($data['manufactureYear']);
        $auto->setPower($data['power']);
        $auto->setWeight($data['weight']);

        $this->entityManager->persist($auto);
        $this->entityManager->flush();

        return new JsonResponse(['success' => true]);
    }

    /**
     * @Route("/auto/add", name="auto_add", methods={"POST"})
     */
    public function addAuto(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['success' => false, 'message' => 'Invalid data provided.'], 400);
        }

        try {
            $auto = new Auto();
            $auto->setModel($data['model']);
            $auto->setManufactureYear($data['manufactureYear']);
            $auto->setPower($data['power']);
            $auto->setWeight($data['weight']);
            
            $this->entityManager->persist($auto);
            $this->entityManager->flush();

            return new JsonResponse(['success' => true]);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'message' => 'Error adding auto.'], 500);
        }
    }


/**
 * @Route("/auto/add-image/{id}", name="auto_add_image", methods={"POST"})
 */
public function addImage(Auto $auto, Request $request): Response
{
    $imageFile = $request->files->get('car_image');

    if ($imageFile) {
        $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

        try {
            $imageFile->move(
                $this->getParameter('images_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            // ide kaphatsz egy hibát, ha bármilyen probléma merül fel a fájl feltöltése során
        }

        $auto->setImageName($newFilename);
        $this->entityManager->persist($auto);
        $this->entityManager->flush();
    }

    return $this->redirectToRoute('app_auto'); // vagy bármelyik másik route, ahová szeretnél irányítani a feltöltés után
}
/**
 * @Route("/auto/{id}/delete-image", name="auto_delete_image", methods={"DELETE"})
 */
public function deleteImage(Auto $auto): JsonResponse
{
    if (!$auto) {
        return new JsonResponse(['success' => false, 'message' => 'Auto not found.'], 404);
    }

    // Kép törlése a fájlrendszerből
    $imagePath = $this->getParameter('images_directory') . '/' . $auto->getImageName();
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Kép név törlése az adatbázisból
    $auto->setImageName(null);
    $this->entityManager->persist($auto);
    $this->entityManager->flush();

    return new JsonResponse(['success' => true, 'message' => 'Image deleted successfully.']);
}

/**
 * @Route("/auto/replace-image/{id}", name="auto_replace_image", methods={"POST"})
 */
public function replaceImage(Auto $auto, Request $request): Response
{
    $imageFile = $request->files->get('car_image');

    if ($imageFile) {
        $originalImagePath = $this->getParameter('images_directory') . '/' . $auto->getImageName();
        if (file_exists($originalImagePath)) {
            unlink($originalImagePath);
        }

        $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

        try {
            $imageFile->move(
                $this->getParameter('images_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            $this->addFlash('error', 'Hiba történt a kép feltöltése közben.');
            return $this->redirectToRoute('app_auto');
        }

        $auto->setImageName($newFilename);
        $this->entityManager->persist($auto);
        $this->entityManager->flush();

        $this->addFlash('success', 'Kép sikeresen lecserélve!');
    }

    return $this->redirectToRoute('app_auto');
}


}
 
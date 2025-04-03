<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

final class TestController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/post', name: 'app_post')]
    public function index(Request $request, PostRepository $postRepository): Response
    {
        // Créer un nouvel objet Post
        $post = new Post();

        // Récupérer les fichiers d'images du dossier public/uploads/images/
        $imageDirectory = $this->getParameter('images_directory');
        $images = array_diff(scandir($imageDirectory), ['..', '.']); // Récupérer les fichiers du dossier, exclure . et ..

        // Créer et gérer le formulaire
        $form = $this->createForm(PostType::class, $post, [
            'images' => $images, // Passer la liste des images au formulaire
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder le post dans la base de données
            $this->entityManager->persist($post);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_post');
        }

        return $this->render('test/index.html.twig', [
            'form' => $form->createView(),
            'posts' => $postRepository->findAll(), // Afficher tous les posts
        ]);
    }
}




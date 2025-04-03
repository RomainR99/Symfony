<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

final class TestController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(Request $request, PostRepository $postRepository): Response
    {
        // Créer un nouvel objet Post
        $post = new Post();

        // Créer et gérer le formulaire
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le fichier image téléchargé
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                try {
                    // Créer un nom de fichier unique
                    $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                    // Déplacer l'image dans le dossier public/uploads/images/
                    $imageFile->move(
                        $this->getParameter('images_directory'), // Répertoire où l'image sera stockée
                        $newFilename
                    );

                    // Enregistrer le nom de fichier dans l'entité
                    $post->setImageFilename($newFilename);
                } catch (FileException $e) {
                    // Gestion des erreurs de téléchargement
                    $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de l\'image.');
                }
            }

            // Sauvegarder le post dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            // Rediriger vers la page de la liste des posts ou vers la page de succès
            return $this->redirectToRoute('app_post');
        }

        // Afficher le formulaire et les posts de l'utilisateur (si nécessaire)
        return $this->render('test/index.html.twig', [
            'form' => $form->createView(),
            'posts' => $postRepository->findByUser($this->getUser()), // Trouver les posts de l'utilisateur connecté
        ]);
    }
}




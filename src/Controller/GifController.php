<?php

namespace App\Controller;

use App\Entity\Gif;
use App\Form\GifType;
use App\Repository\GifRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gif')]
class GifController extends AbstractController
{
    #[Route('/', name: 'app_gif_index', methods: ['GET'])]
    public function index(GifRepository $gifRepository): Response
    {
        return $this->render('gif/index.html.twig', [
            'gifs' => $gifRepository->findAll(),
        ]);
    }

    #[Route('/browse', name: 'app_gif_browse', methods: ['GET'])]
    public function browse(UserRepository $userRepository, GifRepository $gifRepository): Response
    {

        /** @var \App\Entity\User */
        $user = $this->getUser();

        return $this->render('gif/browse.html.twig', [
            'user' => $user,
            'gifs' => $gifRepository->findAll(),
        ]);
    }

    #[Route('/random', name: 'app_gif_random', methods: ['GET'])]
    public function random(GifRepository $gifRepository): Response
    {

        $allGifs = $gifRepository->findAll();
        $gifCount = count($allGifs);
        $randomGif = $allGifs[rand(0, $gifCount - 1)];

        /** @var \App\Entity\User */
        $user = $this->getUser();
        if ($user) {
            $collectionCheck = $user->isInCollection($randomGif);
        } else {
            $collectionCheck = false;
        }

        return $this->render('gif/randomGif.html.twig', [
            'randomGif' => $randomGif,
            'collectionCheck' => $collectionCheck
        ]);
    }

    #[Route('/myCollection', name: 'app_gif_collection', methods: ['GET'])]
    public function collection(GifRepository $gifRepository): Response
    {
        $user = $this->getUser();

        return $this->render('gif/myCollection.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/collect', name: 'app_gif_collect', methods: ['GET'])]
    public function colect(Gif $gif, UserRepository $userRepository): Response
    {

        if (!$gif) {
            throw $this->createNotFoundException(
                'No GIF with this id found in GIF\'s table.'
            );
        }

        /** @var \App\Entity\User */
        $user = $this->getUser();

        if ($user) {
            if ($user->isInCollection($gif)) {
                $user->removeFromCollection($gif);
            } else {
                $user->addToCollection($gif);
            }
            $userRepository->save($user, true);
        } else {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('gif/myCollection.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/vote', name: 'app_gif_vote', methods: ['GET'])]
    public function vote(Gif $gif, GifRepository $gifRepository): Response
    {

        $nbOfVotes = $gif->getNbOfVotes();
        $nbOfVotes++;
        $gif->setNbOfVotes($nbOfVotes);

        $gifRepository->save($gif, true);

        return $this->render('gif/randomGif.html.twig', [
            'randomGif' => $gif,
        ]);
    }

    #[Route('/new', name: 'app_gif_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GifRepository $gifRepository): Response
    {
        $gif = new Gif();
        $form = $this->createForm(GifType::class, $gif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gifRepository->save($gif, true);

            return $this->redirectToRoute('app_gif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gif/new.html.twig', [
            'gif' => $gif,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gif_show', methods: ['GET'])]
    public function show(Gif $gif): Response
    {
        return $this->render('gif/show.html.twig', [
            'gif' => $gif,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gif_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gif $gif, GifRepository $gifRepository): Response
    {
        $form = $this->createForm(GifType::class, $gif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gifRepository->save($gif, true);

            return $this->redirectToRoute('app_gif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gif/edit.html.twig', [
            'gif' => $gif,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gif_delete', methods: ['POST'])]
    public function delete(Request $request, Gif $gif, GifRepository $gifRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $gif->getId(), $request->request->get('_token'))) {
            $gifRepository->remove($gif, true);
        }

        return $this->redirectToRoute('app_gif_index', [], Response::HTTP_SEE_OTHER);
    }
}

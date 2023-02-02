<?php

namespace App\Controller;

use App\Repository\GifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gif')]
class DundiesController extends AbstractController
{
    #[Route('/dundies', name: 'app_gif_dundies', methods: ['GET'])]
    public function index(GifRepository $gifRepository): Response
    {

        $dundiesGif = $gifRepository->findOneBy([], ['nbOfVotes' => 'DESC']);

        /** @var \App\Entity\User */
        $user = $this->getUser();
        if ($user) {
            $collectionCheck = $user->isInCollection($dundiesGif);
        } else {
            $collectionCheck = false;
        }

        return $this->render('gif/dundies.html.twig', [
            'dundiesGif' => $dundiesGif,
            'collectionCheck' => $collectionCheck
        ]);
    }
}

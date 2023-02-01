<?php

namespace App\Controller;

use App\Entity\Gif;
use App\Form\GifType;
use App\Repository\GifRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gif')]
class VoteController extends AbstractController
{
    #[Route('/{id}/vote', name: 'app_gif_vote', methods: ['GET'])]
    public function vote(Gif $gif, UserRepository $userRepository, GifRepository $gifRepository): Response
    {
        /** @var \App\Entity\User */
        $user = $this->getUser();

        if ($user) {
            $nbOfVotes = $gif->getNbOfVotes();
            $nbOfVotes++;
            $gif->setNbOfVotes($nbOfVotes);
            $gifRepository->save($gif, true);
            $user->addToVotes($gif);
            $userRepository->save($user, true);
        } else {
            $this->addFlash('info', "You must be logged to vote");
            return $this->redirectToRoute('app_login');
        }

        return $this->json([]);
    }
}

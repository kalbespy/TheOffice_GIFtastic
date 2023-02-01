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
class CollectController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/myCollection', name: 'app_gif_collection', methods: ['GET'])]
    public function collection(GifRepository $gifRepository): Response
    {
        $user = $this->getUser();

        return $this->render('gif/myCollection.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/collect', name: 'app_gif_collect', methods: ['GET'])]
    public function collect(Gif $gif, UserRepository $userRepository): Response
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
            $this->addFlash('info', "You must be logged to collect GIF");
            return $this->redirectToRoute('app_login');
        }

        $isInCollection = $user->isInCollection($gif);

        return $this->json([
            'isInCollection' => $isInCollection
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/remove', name: 'app_gif_remove', methods: ['GET'])]
    public function remove(Gif $gif, UserRepository $userRepository): Response
    {

        if (!$gif) {
            throw $this->createNotFoundException(
                'No GIF with this id found in GIF\'s table.'
            );
        }

        /** @var \App\Entity\User */
        $user = $this->getUser();
        $user->removeFromCollection($gif);
        $userRepository->save($user, true);

        return $this->json([]);
    }
}

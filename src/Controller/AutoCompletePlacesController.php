<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AutoCompletePlacesController extends AbstractController
{
    /**
     * @Route("/places", name="auto_complete_places")
     */
    public function index(): Response
    {
        $placesKey = $this->getParameter('algolia_places_key');
        $id = $this->getParameter('algolia_places_id');

        return $this->render('auto_complete_places/index.html.twig', [
            'key' => $placesKey,
            'id' => $id
        ]);
    }
}

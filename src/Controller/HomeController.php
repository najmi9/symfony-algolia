<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Form\SearchType;
use Algolia\AlgoliaSearch\SearchClient;
use Algolia\SearchBundle\SearchService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Algolia\AlgoliaSearch\Exceptions\AlgoliaException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * Search Method
     *
     * @Route("/search", name="search")
     *
     * @param Request $request
     * @param SearchService $searchService
     * @return Response
     * @throws AlgoliaException
     */
    public function search(Request $request, SearchService $searchService): Response
    {
        $results = [];
        $form = $this->createForm(SearchType::class);
        $page = $request->query->get('page', 0);
        $form->handleRequest($request);
        $post = false;

        if ($form->isSubmitted() && $form->isValid()) {
            $q = $form->get('q')->getData();

            $min = $form->get('min')->getData();
            $max = $form->get('max')->getData();
            $isEnabled =  $form->get('isEnabled')->getData() ? 1 : 0;

            $filters = "isEnabled = {$isEnabled}";

            $min > 0 ? $filters .= " AND (price > {$min})" : null;
            $max > 0 ? $filters .= " AND (price < {$max})" : null;
            $post = true;
            $results = $searchService->rawSearch(Product::class, $q, [
                'query' => $q,
                'page' => $page,
                'hitsPerPage' => 10,
                'attributesToRetrieve' => ['name', 'description', 'price', 'isEnabled'],
                'filters' => $filters,
            ]);
        }

        return $this->render('home/search.html.twig', [
            'results' => $results,
            'form' => $form->createView(),
            'post' => $post,
        ]);
    }

    /**
     * Generate a new search only key for client side.
     * 
     * @Route("/key", name="key", methods={"GET"})
     */
    public function key(): JsonResponse
    {
        $searchOnlyAPIKey = $this->getParameter('search_only_key');
        $validUntil = time() + 3600;

        $searchKey = SearchClient::generateSecuredApiKey(
            $searchOnlyAPIKey,
            [
                'validUntil' => $validUntil
            ]
        );

        return $this->json(['key' => $searchKey]);
    }
}

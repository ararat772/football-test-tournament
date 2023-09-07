<?php

namespace App\Controller;

use App\Services\Tournament\TournamentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TournamentController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em, protected TournamentService $tournamentService)
    {
        $this->em = $em;
    }

    #[Route('/tournaments', name: 'app_tournaments', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $tournamentData = $this->tournamentService->getAllTournaments();

        return $this->json(['tournaments' => $tournamentData]);
    }

    #[Route('/tournaments', name: 'app_tournament_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data              = $request->toArray();
        $createdTournament = $this->tournamentService->createTournament($data);

        return $this->json(['message' => "Tournament " . $createdTournament->getName() . ' created successfully!']);
    }

    #[Route('/tournaments/{slug}', name: 'app_tournament_matches', methods: ['GET'])]
    public function matches($slug): JsonResponse
    {
        $matchesArray = $this->tournamentService->getMatchesByTournamentSlug($slug);

        if ($matchesArray) {
            return $this->json(['matches' => $matchesArray]);
        }

        return $this->json(['message' => 'Tournament not found!'], 404);
    }
}

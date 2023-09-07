<?php

namespace App\Controller;

use App\Services\Teams\TeamsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeamController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em, protected TeamsService $teamsService)
    {
        $this->em = $em;
    }

    #[Route('/teams', name: 'app_teams', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $teamsArray = $this->teamsService->getAllTeams();
        return $this->json(['teams' => $teamsArray]);
    }

    #[Route('/teams', name: 'app_team_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data        = $request->toArray();
        $createdTeam = $this->teamsService->createTeam($data);

        return $this->json(['message' => "Teams " . $createdTeam->getName() . ' created successfully!']);
    }

    #[Route('/teams/{id}', name: 'app_team_delete', methods: ['DELETE'])]
    public function delete($id): JsonResponse
    {
        $isDeleted = $this->teamsService->deleteTeam((int)$id);

        if ($isDeleted) {
            return $this->json(['message' => 'Team deleted successfully!']);
        }

        return $this->json(['message' => 'Team not found!'], 404);
    }
}

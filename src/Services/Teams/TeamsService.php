<?php

namespace App\Services\Teams;

use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;

class TeamsService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Fetches all teams.
     *
     * @return array An array of all teams.
     */
    public function getAllTeams(): array
    {
        $teams = $this->em->getRepository(Team::class)->findAll();

        $teamsArray = [];
        foreach ($teams as $team) {
            $teamsArray[] = $team->toArray();
        }

        return $teamsArray;
    }

    /**
     * Creates a new team.
     *
     * @param array $data The data required to create a team.
     *
     * @return Team The created team entity.
     */
    public function createTeam(array $data): Team
    {
        $team = new Team();
        $team->setName($data['name']);

        $this->em->persist($team);
        $this->em->flush();

        return $team;
    }

    /**
     * Deletes a team by its ID.
     *
     * @param int $id The ID of the team to delete.
     *
     * @return bool True if deletion was successful, false otherwise.
     */
    public function deleteTeam(int $id): bool
    {
        $team = $this->em->getRepository(Team::class)->find($id);

        if (!$team) {
            return false;
        }

        $this->em->remove($team);
        $this->em->flush();

        return true;
    }
}

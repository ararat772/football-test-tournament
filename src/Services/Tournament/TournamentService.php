<?php

namespace App\Services\Tournament;

use App\Entity\Team;
use App\Entity\Matchh;
use App\Entity\Tournament;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TournamentService extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Fetches all tournaments.
     *
     * @return array An array of all tournaments.
     */
    public function getAllTournaments(): array
    {
        $tournaments = $this->em->getRepository(Tournament::class)->findAll();

        $tournamentData = [];
        foreach ($tournaments as $tournament) {
            $tournamentData[] = $tournament->toArray();
        }

        return $tournamentData;
    }

    /**
     * Creates a new tournament.
     *
     * @param array $data The data required to create a tournament.
     *
     * @return Tournament The created tournament entity.
     */
    public function createTournament(array $data): Tournament
    {
        $tournament = new Tournament();

        $tournament->setName($data['tournaments']);

        $slugger = new AsciiSlugger();
        $slug    = $slugger->slug($data['tournaments']);

        $tournament->setSlug($slug);
        $this->em->persist($tournament);

        $matches = $this->generateMatches($this->em->getRepository(Team::class)->findAll(), $tournament);
        foreach ($matches as $match) {
            $this->em->persist($match);
        }

        $this->em->flush();

        return $tournament;
    }

    /**
     * Generates matches for a given tournament and teams.
     *
     * @param array $teams An array of teams.
     * @param Tournament $tournament The related tournament.
     *
     * @return array An array of generated matches.
     */
    private function generateMatches(array $teams, Tournament $tournament): array
    {
        $totalTeams = count($teams);
        if ($totalTeams < 2) {
            return [];
        }

        $matches    = [];
        $usedPairs  = [];
        $dayCounter = 0;

        for ($i = 0; $i < $totalTeams - 1; $i++) {
            for ($j = $i + 1; $j < $totalTeams; $j++) {
                $pairId = $teams[$i]->getId() . '-' . $teams[$j]->getId();
                if (!in_array($pairId, $usedPairs)) {
                    $match = new Matchh();
                    $match->setTeam1($teams[$i]);
                    $match->setTeam2($teams[$j]);
                    $match->setTournament($tournament);

                    $matchDate = (new \DateTime())->modify("+$dayCounter days");
                    $match->setDate($matchDate);

                    $matches[]   = $match;
                    $usedPairs[] = $pairId;
                    $usedPairs[] = $teams[$j]->getId() . '-' . $teams[$i]->getId();

                    if (count($matches) % 4 == 0) {
                        $dayCounter++;
                    }
                }
            }
        }

        return $matches;
    }

    /**
     * Retrieves matches based on a given tournament slug.
     *
     * @param string $slug The slug of the tournament.
     *
     * @return array|null An array of matches related to the tournament or null if not found.
     */
    public function getMatchesByTournamentSlug(string $slug): ?array
    {
        $tournament = $this->em->getRepository(Tournament::class)->findOneBy(['slug' => $slug]);

        if (!$tournament) {
            return null;
        }

        $matches      = $this->em->getRepository(Matchh::class)->findBy(['tournament' => $tournament]);
        $matchesArray = [];

        foreach ($matches as $match) {
            $team1 = $match->getTeam1();
            $team2 = $match->getTeam2();

            $matchesArray[] = [
                'id'         => $match->getId(),
                'date'       => $match->getDate()->format('Y-m-d H:i:s'),
                'team1'      => [
                    'id'   => $team1->getId(),
                    'name' => method_exists($team1, 'getName') ? $team1->getName() : null
                ],
                'team2'      => [
                    'id'   => $team2->getId(),
                    'name' => method_exists($team2, 'getName') ? $team2->getName() : null
                ],
                'tournament' => [
                    'id'   => $tournament->getId(),
                    'name' => $tournament->getName(),
                    'slug' => $tournament->getSlug()
                ]
            ];
        }

        return $matchesArray;
    }
}
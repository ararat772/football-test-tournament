<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230906202055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Matchh Entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE matchh_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE matchh (id INT NOT NULL, team1_id INT NOT NULL, team2_id INT NOT NULL, tournament_id INT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_MATCHH_TEAM1_ID ON matchh (team1_id)');
        $this->addSql('CREATE INDEX IDX_MATCHH_TEAM2_ID ON matchh (team2_id)');
        $this->addSql('CREATE INDEX IDX_MATCHH_TOURNAMENT_ID ON matchh (tournament_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE matchh');
        $this->addSql('DROP SEQUENCE matchh_id_seq');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230906202101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Tournament Entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE tournament_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE tournament (id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_TOURNAMENT_SLUG ON tournament (slug)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE tournament');
        $this->addSql('DROP SEQUENCE tournament_id_seq');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20241012181002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

        $this->addSql('ALTER TABLE category RENAME COLUMN nom TO name');
        $this->addSql('ALTER TABLE language RENAME COLUMN nom TO name');
        $this->addSql('ALTER TABLE media ADD casting JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE category RENAME COLUMN name TO nom');
        $this->addSql('ALTER TABLE media DROP casting');
        $this->addSql('ALTER TABLE language RENAME COLUMN name TO nom');
    }
}

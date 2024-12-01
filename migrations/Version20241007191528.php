<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20241007191528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

        $this->addSql('ALTER TABLE serie DROP name');
    }

    public function down(Schema $schema): void
    {

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE serie ADD name VARCHAR(255) NOT NULL');
    }
}

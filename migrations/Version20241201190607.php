<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20241201190607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE media ADD score DOUBLE PRECISION DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER roles DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE media DROP score');
        $this->addSql('ALTER TABLE "user" ALTER roles SET DEFAULT \'["ROLE_USER"]\'');
    }
}

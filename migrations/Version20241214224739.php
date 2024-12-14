<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20241214224739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
       
        $this->addSql('ALTER TABLE media ADD type VARCHAR(255) NULL');
    }

    public function down(Schema $schema): void
    {
       
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE media DROP type');
    }
}

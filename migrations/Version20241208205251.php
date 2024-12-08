<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20241208205251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE media ALTER score DROP DEFAULT');
        $this->addSql('ALTER TABLE "user" ADD reset_token VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE media ALTER score SET DEFAULT \'0\'');
        $this->addSql('ALTER TABLE "user" DROP reset_token');
    }
}

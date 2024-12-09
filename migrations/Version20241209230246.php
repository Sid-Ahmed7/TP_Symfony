<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20241209230246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        
        $this->addSql('CREATE SEQUENCE upload_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE upload (id INT NOT NULL, uploaded_by_id INT NOT NULL, uploaded_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_17BDE61FA2B28FE8 ON upload (uploaded_by_id)');
        $this->addSql('COMMENT ON COLUMN upload.uploaded_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE upload ADD CONSTRAINT FK_17BDE61FA2B28FE8 FOREIGN KEY (uploaded_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
   
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE upload_id_seq CASCADE');
        $this->addSql('ALTER TABLE upload DROP CONSTRAINT FK_17BDE61FA2B28FE8');
        $this->addSql('DROP TABLE upload');
    }
}

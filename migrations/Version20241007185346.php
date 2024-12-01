<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20241007185346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE comment ADD media_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9474526CEA9FDD75 ON comment (media_id)');
        $this->addSql('ALTER TABLE playlist ADD author_id INT NOT NULL');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112DF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D782112DF675F31B ON playlist (author_id)');
        $this->addSql('ALTER TABLE playlist_subscription ADD playlist_id INT NOT NULL');
        $this->addSql('ALTER TABLE playlist_subscription ADD subscriber_id INT NOT NULL');
        $this->addSql('ALTER TABLE playlist_subscription ADD CONSTRAINT FK_832940C6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist_subscription ADD CONSTRAINT FK_832940C7808B1AD FOREIGN KEY (subscriber_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_832940C6BBD148 ON playlist_subscription (playlist_id)');
        $this->addSql('CREATE INDEX IDX_832940C7808B1AD ON playlist_subscription (subscriber_id)');
        $this->addSql('ALTER TABLE serie ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE subscription_history ADD subscription_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription_history ADD subscriber_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription_history ADD CONSTRAINT FK_54AF90D09A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscription_history ADD CONSTRAINT FK_54AF90D07808B1AD FOREIGN KEY (subscriber_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_54AF90D09A1887DC ON subscription_history (subscription_id)');
        $this->addSql('CREATE INDEX IDX_54AF90D07808B1AD ON subscription_history (subscriber_id)');
        $this->addSql('ALTER TABLE watch_history ADD watcher_id INT NOT NULL');
        $this->addSql('ALTER TABLE watch_history ADD media_id INT NOT NULL');
        $this->addSql('ALTER TABLE watch_history ADD CONSTRAINT FK_DE44EFD8C300AB5D FOREIGN KEY (watcher_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE watch_history ADD CONSTRAINT FK_DE44EFD8EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DE44EFD8C300AB5D ON watch_history (watcher_id)');
        $this->addSql('CREATE INDEX IDX_DE44EFD8EA9FDD75 ON watch_history (media_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE subscription_history DROP CONSTRAINT FK_54AF90D09A1887DC');
        $this->addSql('ALTER TABLE subscription_history DROP CONSTRAINT FK_54AF90D07808B1AD');
        $this->addSql('DROP INDEX IDX_54AF90D09A1887DC');
        $this->addSql('DROP INDEX IDX_54AF90D07808B1AD');
        $this->addSql('ALTER TABLE subscription_history DROP subscription_id');
        $this->addSql('ALTER TABLE subscription_history DROP subscriber_id');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CEA9FDD75');
        $this->addSql('DROP INDEX IDX_9474526CEA9FDD75');
        $this->addSql('ALTER TABLE comment DROP media_id');
        $this->addSql('ALTER TABLE serie DROP name');
        $this->addSql('ALTER TABLE watch_history DROP CONSTRAINT FK_DE44EFD8C300AB5D');
        $this->addSql('ALTER TABLE watch_history DROP CONSTRAINT FK_DE44EFD8EA9FDD75');
        $this->addSql('DROP INDEX IDX_DE44EFD8C300AB5D');
        $this->addSql('DROP INDEX IDX_DE44EFD8EA9FDD75');
        $this->addSql('ALTER TABLE watch_history DROP watcher_id');
        $this->addSql('ALTER TABLE watch_history DROP media_id');
        $this->addSql('ALTER TABLE playlist_subscription DROP CONSTRAINT FK_832940C6BBD148');
        $this->addSql('ALTER TABLE playlist_subscription DROP CONSTRAINT FK_832940C7808B1AD');
        $this->addSql('DROP INDEX IDX_832940C6BBD148');
        $this->addSql('DROP INDEX IDX_832940C7808B1AD');
        $this->addSql('ALTER TABLE playlist_subscription DROP playlist_id');
        $this->addSql('ALTER TABLE playlist_subscription DROP subscriber_id');
        $this->addSql('ALTER TABLE playlist DROP CONSTRAINT FK_D782112DF675F31B');
        $this->addSql('DROP INDEX IDX_D782112DF675F31B');
        $this->addSql('ALTER TABLE playlist DROP author_id');
    }
}

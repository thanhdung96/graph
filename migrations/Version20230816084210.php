<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230816084210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added employee assignment to device';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE device ADD assignee_id VARCHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE device ADD CONSTRAINT FK_92FB68E59EC7D60 FOREIGN KEY (assignee_id) REFERENCES employee (id)');
        $this->addSql('CREATE INDEX IDX_92FB68E59EC7D60 ON device (assignee_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE device DROP FOREIGN KEY FK_92FB68E59EC7D60');
        $this->addSql('DROP INDEX IDX_92FB68E59EC7D60 ON device');
        $this->addSql('ALTER TABLE device DROP assignee_id');
    }
}

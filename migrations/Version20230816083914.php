<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230816083914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added base entities';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE department (id VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, deleted DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE device (id VARCHAR(36) NOT NULL, name VARCHAR(128) NOT NULL, brand VARCHAR(32) NOT NULL, purchase_date DATE DEFAULT NULL, status VARCHAR(16) NOT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, deleted DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id VARCHAR(36) NOT NULL, department_supervised_id VARCHAR(36) DEFAULT NULL, department_id VARCHAR(36) DEFAULT NULL, first_name VARCHAR(32) NOT NULL, last_name VARCHAR(32) NOT NULL, gender TINYINT(1) NOT NULL, salary DOUBLE PRECISION NOT NULL, phone_number VARCHAR(16) DEFAULT NULL, motor_brand VARCHAR(32) DEFAULT NULL, plate_number VARCHAR(32) DEFAULT NULL, nationality VARCHAR(16) NOT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, deleted DATETIME DEFAULT NULL, INDEX IDX_5D9F75A153BA6243 (department_supervised_id), INDEX IDX_5D9F75A1AE80F5DF (department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A153BA6243 FOREIGN KEY (department_supervised_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A153BA6243');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1AE80F5DF');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE device');
        $this->addSql('DROP TABLE employee');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620122737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projects_dev_tools (projects_id INT NOT NULL, dev_tools_id INT NOT NULL, INDEX IDX_F889DBBF1EDE0F55 (projects_id), INDEX IDX_F889DBBF37B047EF (dev_tools_id), PRIMARY KEY(projects_id, dev_tools_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects_dev_tools ADD CONSTRAINT FK_F889DBBF1EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects_dev_tools ADD CONSTRAINT FK_F889DBBF37B047EF FOREIGN KEY (dev_tools_id) REFERENCES dev_tools (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects_dev_tools DROP FOREIGN KEY FK_F889DBBF1EDE0F55');
        $this->addSql('ALTER TABLE projects_dev_tools DROP FOREIGN KEY FK_F889DBBF37B047EF');
        $this->addSql('DROP TABLE projects_dev_tools');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507142128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, training TINYINT(1) NOT NULL, INDEX IDX_5C93B3A4A76ED395 (user_id), UNIQUE INDEX UNIQ_IDENTIFIER_NAME (name), UNIQUE INDEX UNIQ_IDENTIFIER_URL (url), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects_skills (projects_id INT NOT NULL, skills_id INT NOT NULL, INDEX IDX_14C58A8F1EDE0F55 (projects_id), INDEX IDX_14C58A8F7FF61858 (skills_id), PRIMARY KEY(projects_id, skills_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE projects_skills ADD CONSTRAINT FK_14C58A8F1EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects_skills ADD CONSTRAINT FK_14C58A8F7FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4A76ED395');
        $this->addSql('ALTER TABLE projects_skills DROP FOREIGN KEY FK_14C58A8F1EDE0F55');
        $this->addSql('ALTER TABLE projects_skills DROP FOREIGN KEY FK_14C58A8F7FF61858');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE projects_skills');
    }
}

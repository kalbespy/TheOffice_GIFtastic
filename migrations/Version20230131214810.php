<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131214810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE collection (user_id INT NOT NULL, gif_id INT NOT NULL, INDEX IDX_FC4D6532A76ED395 (user_id), INDEX IDX_FC4D6532B75C3F80 (gif_id), PRIMARY KEY(user_id, gif_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE collection ADD CONSTRAINT FK_FC4D6532A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE collection ADD CONSTRAINT FK_FC4D6532B75C3F80 FOREIGN KEY (gif_id) REFERENCES gif (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collection DROP FOREIGN KEY FK_FC4D6532A76ED395');
        $this->addSql('ALTER TABLE collection DROP FOREIGN KEY FK_FC4D6532B75C3F80');
        $this->addSql('DROP TABLE collection');
    }
}

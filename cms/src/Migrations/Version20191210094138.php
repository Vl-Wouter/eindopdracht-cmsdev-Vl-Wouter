<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191210094138 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE period (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, start_date DATE NOT NULL, duration INT NOT NULL, end_date DATE NOT NULL, INDEX IDX_C5B81ECE19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE period ADD CONSTRAINT FK_C5B81ECE19EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task ADD period_id INT NOT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25EC8B7ADE FOREIGN KEY (period_id) REFERENCES period (id)');
        $this->addSql('CREATE INDEX IDX_527EDB25EC8B7ADE ON task (period_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25EC8B7ADE');
        $this->addSql('DROP TABLE period');
        $this->addSql('DROP INDEX IDX_527EDB25EC8B7ADE ON task');
        $this->addSql('ALTER TABLE task DROP period_id');
    }
}

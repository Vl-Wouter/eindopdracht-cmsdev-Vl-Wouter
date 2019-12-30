<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191211090525 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2519EB6921');
        $this->addSql('DROP INDEX IDX_527EDB2519EB6921 ON task');
        $this->addSql('ALTER TABLE task DROP client_id');
        $this->addSql('ALTER TABLE period DROP duration, DROP active');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE period ADD duration INT NOT NULL, ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE task ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2519EB6921 FOREIGN KEY (client_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_527EDB2519EB6921 ON task (client_id)');
    }
}

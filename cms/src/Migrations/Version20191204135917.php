<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191204135917 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task ADD client_id INT NOT NULL, ADD employee_id INT NOT NULL, ADD date DATE NOT NULL, ADD begin_time TIME NOT NULL, ADD end_time TIME NOT NULL, ADD break DOUBLE PRECISION NOT NULL, ADD activity LONGTEXT NOT NULL, ADD materials LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2519EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB258C03F15C FOREIGN KEY (employee_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_527EDB2519EB6921 ON task (client_id)');
        $this->addSql('CREATE INDEX IDX_527EDB258C03F15C ON task (employee_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2519EB6921');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB258C03F15C');
        $this->addSql('DROP INDEX IDX_527EDB2519EB6921 ON task');
        $this->addSql('DROP INDEX IDX_527EDB258C03F15C ON task');
        $this->addSql('ALTER TABLE task DROP client_id, DROP employee_id, DROP date, DROP begin_time, DROP end_time, DROP break, DROP activity, DROP materials');
    }
}

<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181016142911 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE friends CHANGE id_follower follower_id INT NOT NULL');
        $this->addSql('ALTER TABLE friends ADD CONSTRAINT FK_21EE7069AC24F853 FOREIGN KEY (follower_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_21EE7069AC24F853 ON friends (follower_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE friends DROP FOREIGN KEY FK_21EE7069AC24F853');
        $this->addSql('DROP INDEX IDX_21EE7069AC24F853 ON friends');
        $this->addSql('ALTER TABLE friends CHANGE follower_id id_follower INT NOT NULL');
    }
}

<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181015151945 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A1BE284D');
        $this->addSql('DROP INDEX IDX_8D93D649A1BE284D ON user');
        $this->addSql('ALTER TABLE user CHANGE school_id_id school_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649C32A47EE ON user (school_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C32A47EE');
        $this->addSql('DROP INDEX IDX_8D93D649C32A47EE ON user');
        $this->addSql('ALTER TABLE user CHANGE school_id school_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A1BE284D FOREIGN KEY (school_id_id) REFERENCES school (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649A1BE284D ON user (school_id_id)');
    }
}

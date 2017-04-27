<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170427131928 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE law_schedule_event_types (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE law_schedule_events ADD type_id INT UNSIGNED DEFAULT NULL, DROP type, CHANGE status status INT NOT NULL');
        $this->addSql('ALTER TABLE law_schedule_events ADD CONSTRAINT FK_BD343051C54C8C93 FOREIGN KEY (type_id) REFERENCES law_schedule_event_types (id)');
        $this->addSql('CREATE INDEX IDX_BD343051C54C8C93 ON law_schedule_events (type_id)');

        $this->addSql('INSERT INTO `law_schedule_event_types` (`type`) VALUES (\'Встреча\');');
        $this->addSql('INSERT INTO `law_schedule_event_types` (`type`) VALUES (\'Звонок\');');
        $this->addSql('INSERT INTO `law_schedule_event_types` (`type`) VALUES (\'Посещение суда\');');
        $this->addSql('INSERT INTO `law_schedule_event_types` (`type`) VALUES (\'Документы\');');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE law_schedule_events DROP FOREIGN KEY FK_BD343051C54C8C93');
        $this->addSql('DROP TABLE law_schedule_event_types');
        $this->addSql('ALTER TABLE law_orders CHANGE status status TINYINT(1) NOT NULL');
        $this->addSql('DROP INDEX IDX_BD343051C54C8C93 ON law_schedule_events');
        $this->addSql('ALTER TABLE law_schedule_events ADD type TINYINT(1) NOT NULL, DROP type_id, CHANGE status status TINYINT(1) NOT NULL');
    }
}

<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170908210308 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE law_finance (id INT AUTO_INCREMENT NOT NULL, order_id INT UNSIGNED DEFAULT NULL, user_id INT UNSIGNED DEFAULT NULL, dt DATETIME NOT NULL, amount NUMERIC(10, 2) NOT NULL, is_hold TINYINT(1) NOT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX order_id (order_id), INDEX user_id (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE law_finance ADD CONSTRAINT FK_44ECA0B58D9F6D38 FOREIGN KEY (order_id) REFERENCES law_orders (id)');
        $this->addSql('ALTER TABLE law_finance ADD CONSTRAINT FK_44ECA0B5A76ED395 FOREIGN KEY (user_id) REFERENCES law_users (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE law_finance');
        $this->addSql('ALTER TABLE law_orders CHANGE status status TINYINT(1) NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE law_orders_actions_history CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE law_orders_chat_messages CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE law_orders_files CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE law_orders_payment_info CHANGE payment_type payment_type TINYINT(1) DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE law_private_orders_comments CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE law_schedule_events CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE law_services CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE law_services_categories CHANGE is_available is_available TINYINT(1) DEFAULT \'1\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE law_services_modifications CHANGE service_id service_id INT UNSIGNED NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE law_users CHANGE roles roles LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:json_array)\', CHANGE is_active is_active TINYINT(1) DEFAULT \'1\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP');
    }
}

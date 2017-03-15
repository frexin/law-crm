<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170315150107 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE law_orders_chat_messages (id INT UNSIGNED AUTO_INCREMENT NOT NULL, order_id INT UNSIGNED NOT NULL, user_from INT UNSIGNED NOT NULL, user_to INT UNSIGNED DEFAULT NULL, text MEDIUMTEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, INDEX IDX_CB96D38B8D9F6D38 (order_id), INDEX fk_law_orders_chat_messages_1_idx (user_from), INDEX fk_law_orders_chat_messages_2_idx (user_to), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE law_schedule_events (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED NOT NULL, type TINYINT(1) NOT NULL, status TINYINT(1) NOT NULL, description TEXT DEFAULT NULL, date DATETIME NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, INDEX fk_law_schedule_events_1_idx (user_id), INDEX shedule_events_status_idx (status), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE law_orders_payment_info (id INT UNSIGNED AUTO_INCREMENT NOT NULL, order_id INT UNSIGNED NOT NULL, amount NUMERIC(10, 2) NOT NULL, payment_type TINYINT(1) DEFAULT NULL, is_moneyback TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, INDEX fk_law_orders_payment_info_1_idx (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE law_private_orders_comments (id INT UNSIGNED AUTO_INCREMENT NOT NULL, order_id INT UNSIGNED NOT NULL, is_from_lawyer TINYINT(1) NOT NULL, text TEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, INDEX fk_law_private_order_comments_1_idx (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE law_users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, first_name VARCHAR(180) NOT NULL, second_name VARCHAR(180) NOT NULL, middle_name VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, phone VARCHAR(20) NOT NULL, other_contacts TEXT DEFAULT NULL, email_confirmation_token VARCHAR(180) DEFAULT NULL, phone_confirmation_token VARCHAR(5) DEFAULT NULL, role VARCHAR(180) NOT NULL, avatar_url VARCHAR(512) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, UNIQUE INDEX email_UNIQUE (email), UNIQUE INDEX confirmation_token_UNIQUE (email_confirmation_token), UNIQUE INDEX phone_confirmation_token_UNIQUE (phone_confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE law_orders_files (id INT UNSIGNED AUTO_INCREMENT NOT NULL, order_id INT UNSIGNED NOT NULL, file_path VARCHAR(512) NOT NULL, type TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, INDEX fk_law_orders_files_1_idx (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE law_orders (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED NOT NULL, service_modification_id INT UNSIGNED NOT NULL, lawyer_id INT UNSIGNED DEFAULT NULL, status TINYINT(1) NOT NULL, title VARCHAR(155) NOT NULL, description MEDIUMTEXT NOT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, INDEX orders_status_idx (status), INDEX fk_law_orders_1_idx (user_id), INDEX fk_law_orders_2_idx (service_modification_id), INDEX fk_law_orders_3_idx (lawyer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE law_orders_actions_history (id INT UNSIGNED AUTO_INCREMENT NOT NULL, order_id INT UNSIGNED NOT NULL, action_type TINYINT(1) NOT NULL, additional_information TEXT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, INDEX fk_law_orders_actions_history_1_idx (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE law_services_modifications (id INT UNSIGNED AUTO_INCREMENT NOT NULL, service_id INT UNSIGNED NOT NULL, name VARCHAR(180) NOT NULL, price NUMERIC(10, 2) NOT NULL, description TEXT NOT NULL, time_limit VARCHAR(100) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, INDEX fk_law_orders_modifications_1_idx (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE law_services (id INT UNSIGNED AUTO_INCREMENT NOT NULL, service_category_id INT UNSIGNED DEFAULT NULL, title VARCHAR(180) NOT NULL, short_description TEXT NOT NULL, description MEDIUMTEXT DEFAULT NULL, image_url VARCHAR(512) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, slug VARCHAR(128) NOT NULL, INDEX fk_law_services_1_idx (service_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE law_services_categories (id INT UNSIGNED AUTO_INCREMENT NOT NULL, title VARCHAR(128) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, slug VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE law_orders_chat_messages ADD CONSTRAINT FK_CB96D38B8D9F6D38 FOREIGN KEY (order_id) REFERENCES law_orders (id)');
        $this->addSql('ALTER TABLE law_orders_chat_messages ADD CONSTRAINT FK_CB96D38BC39BEDB9 FOREIGN KEY (user_from) REFERENCES law_users (id)');
        $this->addSql('ALTER TABLE law_orders_chat_messages ADD CONSTRAINT FK_CB96D38BCFD06601 FOREIGN KEY (user_to) REFERENCES law_users (id)');
        $this->addSql('ALTER TABLE law_schedule_events ADD CONSTRAINT FK_BD343051A76ED395 FOREIGN KEY (user_id) REFERENCES law_users (id)');
        $this->addSql('ALTER TABLE law_orders_payment_info ADD CONSTRAINT FK_E8B32DD08D9F6D38 FOREIGN KEY (order_id) REFERENCES law_orders (id)');
        $this->addSql('ALTER TABLE law_private_orders_comments ADD CONSTRAINT FK_8DF163948D9F6D38 FOREIGN KEY (order_id) REFERENCES law_orders (id)');
        $this->addSql('ALTER TABLE law_orders_files ADD CONSTRAINT FK_140F59478D9F6D38 FOREIGN KEY (order_id) REFERENCES law_orders (id)');
        $this->addSql('ALTER TABLE law_orders ADD CONSTRAINT FK_44AC44F5A76ED395 FOREIGN KEY (user_id) REFERENCES law_users (id)');
        $this->addSql('ALTER TABLE law_orders ADD CONSTRAINT FK_44AC44F5686121C3 FOREIGN KEY (service_modification_id) REFERENCES law_services_modifications (id)');
        $this->addSql('ALTER TABLE law_orders ADD CONSTRAINT FK_44AC44F54C19F89F FOREIGN KEY (lawyer_id) REFERENCES law_users (id)');
        $this->addSql('ALTER TABLE law_orders_actions_history ADD CONSTRAINT FK_3DA817C48D9F6D38 FOREIGN KEY (order_id) REFERENCES law_orders (id)');
        $this->addSql('ALTER TABLE law_services_modifications ADD CONSTRAINT FK_6B04BC4CED5CA9E6 FOREIGN KEY (service_id) REFERENCES law_services (id)');
        $this->addSql('ALTER TABLE law_services ADD CONSTRAINT FK_68B98058DEDCBB4E FOREIGN KEY (service_category_id) REFERENCES law_services_categories (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE law_orders_chat_messages DROP FOREIGN KEY FK_CB96D38BC39BEDB9');
        $this->addSql('ALTER TABLE law_orders_chat_messages DROP FOREIGN KEY FK_CB96D38BCFD06601');
        $this->addSql('ALTER TABLE law_schedule_events DROP FOREIGN KEY FK_BD343051A76ED395');
        $this->addSql('ALTER TABLE law_orders DROP FOREIGN KEY FK_44AC44F5A76ED395');
        $this->addSql('ALTER TABLE law_orders DROP FOREIGN KEY FK_44AC44F54C19F89F');
        $this->addSql('ALTER TABLE law_orders_chat_messages DROP FOREIGN KEY FK_CB96D38B8D9F6D38');
        $this->addSql('ALTER TABLE law_orders_payment_info DROP FOREIGN KEY FK_E8B32DD08D9F6D38');
        $this->addSql('ALTER TABLE law_private_orders_comments DROP FOREIGN KEY FK_8DF163948D9F6D38');
        $this->addSql('ALTER TABLE law_orders_files DROP FOREIGN KEY FK_140F59478D9F6D38');
        $this->addSql('ALTER TABLE law_orders_actions_history DROP FOREIGN KEY FK_3DA817C48D9F6D38');
        $this->addSql('ALTER TABLE law_orders DROP FOREIGN KEY FK_44AC44F5686121C3');
        $this->addSql('ALTER TABLE law_services_modifications DROP FOREIGN KEY FK_6B04BC4CED5CA9E6');
        $this->addSql('ALTER TABLE law_services DROP FOREIGN KEY FK_68B98058DEDCBB4E');
        $this->addSql('DROP TABLE law_orders_chat_messages');
        $this->addSql('DROP TABLE law_schedule_events');
        $this->addSql('DROP TABLE law_orders_payment_info');
        $this->addSql('DROP TABLE law_private_orders_comments');
        $this->addSql('DROP TABLE law_users');
        $this->addSql('DROP TABLE law_orders_files');
        $this->addSql('DROP TABLE law_orders');
        $this->addSql('DROP TABLE law_orders_actions_history');
        $this->addSql('DROP TABLE law_services_modifications');
        $this->addSql('DROP TABLE law_services');
        $this->addSql('DROP TABLE law_services_categories');
    }
}

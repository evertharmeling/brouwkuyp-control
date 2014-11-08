<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141108215500 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("ALTER TABLE log CHANGE id id INT(11) NOT NULL");
        $this->addSql('ALTER TABLE log DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE log DROP id');
        $this->addSql('ALTER TABLE log ADD PRIMARY KEY (created_at, topic)');
        $this->addSql("ALTER TABLE log MODIFY COLUMN created_at DATETIME NOT NULL FIRST");
        $this->addSql("ALTER TABLE log ENGINE = MyISAM");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE log DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE log ADD id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE log ADD PRIMARY KEY (id)');
    }
}

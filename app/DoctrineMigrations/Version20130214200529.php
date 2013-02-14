<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130214200529 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE andro_logcat DROP FOREIGN KEY FK_B335459B4073FA85");
        $this->addSql("ALTER TABLE andro_logcat ADD CONSTRAINT FK_B335459B4073FA85 FOREIGN KEY (crashreport_id) REFERENCES andro_crash_report (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE andro_logcat DROP FOREIGN KEY FK_B335459B4073FA85");
        $this->addSql("ALTER TABLE andro_logcat ADD CONSTRAINT FK_B335459B4073FA85 FOREIGN KEY (crashreport_id) REFERENCES andro_crash_report (id)");
    }
}

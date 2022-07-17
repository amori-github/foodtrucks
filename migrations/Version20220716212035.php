<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220716212035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE booking_truck_driver (booking_id INTEGER NOT NULL, truck_driver_id INTEGER NOT NULL, PRIMARY KEY(booking_id, truck_driver_id))');
        $this->addSql('CREATE INDEX IDX_957E7D6D3301C60 ON booking_truck_driver (booking_id)');
        $this->addSql('CREATE INDEX IDX_957E7D6DB6445BB1 ON booking_truck_driver (truck_driver_id)');
        $this->addSql('CREATE TABLE truck_driver (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, phone VARCHAR(20) DEFAULT NULL, email VARCHAR(75) DEFAULT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_truck_driver');
        $this->addSql('DROP TABLE truck_driver');
    }
}

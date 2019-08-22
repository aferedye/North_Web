<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190807083536 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE devis ADD nbrpage INT NOT NULL, ADD partieblog INT DEFAULT NULL, ADD formulaireinscritdevis INT DEFAULT NULL, ADD forum INT DEFAULT NULL, ADD accesmembre INT DEFAULT NULL, ADD gestionfichier INT DEFAULT NULL, ADD cartedynamique INT DEFAULT NULL, ADD integrvideo INT DEFAULT NULL, DROP vendre, DROP presenter, DROP zoning, DROP non, DROP backend, CHANGE maquette maquette INT NOT NULL, CHANGE niveaugraphisme lvlgraphisme INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE devis ADD vendre INT DEFAULT NULL, ADD presenter INT DEFAULT NULL, ADD zoning INT DEFAULT NULL, ADD non INT DEFAULT NULL, ADD niveaugraphisme INT NOT NULL, ADD backend INT DEFAULT NULL, DROP lvlgraphisme, DROP nbrpage, DROP partieblog, DROP formulaireinscritdevis, DROP forum, DROP accesmembre, DROP gestionfichier, DROP cartedynamique, DROP integrvideo, CHANGE maquette maquette INT DEFAULT NULL');
    }
}

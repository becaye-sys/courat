<?php

declare(strict_types=1);

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407023045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, filename VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, slug VARCHAR(255) NOT NULL, title_ar VARCHAR(255) DEFAULT NULL)');
        $this->addSql('DROP TABLE info');
        $this->addSql('DROP INDEX IDX_169E6FB9953C1C61');
        $this->addSql('DROP INDEX IDX_169E6FB923EDC87');
        $this->addSql('DROP INDEX IDX_169E6FB9EA000B10');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course AS SELECT id, class_id, subject_id, source_id, title, video_url, added_at, published_at, start_time FROM course');
        $this->addSql('DROP TABLE course');
        $this->addSql('CREATE TABLE course (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, class_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, source_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, video_url VARCHAR(255) DEFAULT NULL COLLATE BINARY, added_at DATETIME NOT NULL, published_at DATETIME NOT NULL, start_time TIME DEFAULT NULL, CONSTRAINT FK_169E6FB9EA000B10 FOREIGN KEY (class_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_169E6FB923EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_169E6FB9953C1C61 FOREIGN KEY (source_id) REFERENCES video_source (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO course (id, class_id, subject_id, source_id, title, video_url, added_at, published_at, start_time) SELECT id, class_id, subject_id, source_id, title, video_url, added_at, published_at, start_time FROM __temp__course');
        $this->addSql('DROP TABLE __temp__course');
        $this->addSql('CREATE INDEX IDX_169E6FB9953C1C61 ON course (source_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB923EDC87 ON course (subject_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9EA000B10 ON course (class_id)');
        $this->addSql('DROP INDEX IDX_D8698A7612469DE2');
        $this->addSql('DROP INDEX IDX_D8698A768F5EA509');
        $this->addSql('DROP INDEX IDX_D8698A7623EDC87');
        $this->addSql('CREATE TEMPORARY TABLE __temp__document AS SELECT id, subject_id, classe_id, category_id, title, path, size, client_ip, updated_at, file_url, enabled FROM document');
        $this->addSql('DROP TABLE document');
        $this->addSql('CREATE TABLE document (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subject_id INTEGER NOT NULL, classe_id INTEGER NOT NULL, category_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, path VARCHAR(255) DEFAULT NULL COLLATE BINARY, size VARCHAR(255) DEFAULT NULL COLLATE BINARY, client_ip VARCHAR(255) DEFAULT NULL COLLATE BINARY, updated_at DATETIME DEFAULT NULL, file_url VARCHAR(255) DEFAULT NULL COLLATE BINARY, enabled BOOLEAN DEFAULT NULL, CONSTRAINT FK_D8698A7623EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D8698A768F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D8698A7612469DE2 FOREIGN KEY (category_id) REFERENCES document_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO document (id, subject_id, classe_id, category_id, title, path, size, client_ip, updated_at, file_url, enabled) SELECT id, subject_id, classe_id, category_id, title, path, size, client_ip, updated_at, file_url, enabled FROM __temp__document');
        $this->addSql('DROP TABLE __temp__document');
        $this->addSql('CREATE INDEX IDX_D8698A7612469DE2 ON document (category_id)');
        $this->addSql('CREATE INDEX IDX_D8698A768F5EA509 ON document (classe_id)');
        $this->addSql('CREATE INDEX IDX_D8698A7623EDC87 ON document (subject_id)');
        $this->addSql('DROP INDEX IDX_D499BFF69C24126');
        $this->addSql('CREATE TEMPORARY TABLE __temp__planning AS SELECT id, day_id FROM planning');
        $this->addSql('DROP TABLE planning');
        $this->addSql('CREATE TABLE planning (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, day_id INTEGER NOT NULL, CONSTRAINT FK_D499BFF69C24126 FOREIGN KEY (day_id) REFERENCES day (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO planning (id, day_id) SELECT id, day_id FROM __temp__planning');
        $this->addSql('DROP TABLE __temp__planning');
        $this->addSql('CREATE INDEX IDX_D499BFF69C24126 ON planning (day_id)');
        $this->addSql('DROP INDEX IDX_EFA69DF98F5EA509');
        $this->addSql('DROP INDEX IDX_EFA69DF93D865311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__planning_classe AS SELECT planning_id, classe_id FROM planning_classe');
        $this->addSql('DROP TABLE planning_classe');
        $this->addSql('CREATE TABLE planning_classe (planning_id INTEGER NOT NULL, classe_id INTEGER NOT NULL, PRIMARY KEY(planning_id, classe_id), CONSTRAINT FK_EFA69DF93D865311 FOREIGN KEY (planning_id) REFERENCES planning (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EFA69DF98F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO planning_classe (planning_id, classe_id) SELECT planning_id, classe_id FROM __temp__planning_classe');
        $this->addSql('DROP TABLE __temp__planning_classe');
        $this->addSql('CREATE INDEX IDX_EFA69DF98F5EA509 ON planning_classe (classe_id)');
        $this->addSql('CREATE INDEX IDX_EFA69DF93D865311 ON planning_classe (planning_id)');
        $this->addSql('DROP INDEX IDX_26A3639123EDC87');
        $this->addSql('DROP INDEX IDX_26A363913D865311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__planning_subject AS SELECT planning_id, subject_id FROM planning_subject');
        $this->addSql('DROP TABLE planning_subject');
        $this->addSql('CREATE TABLE planning_subject (planning_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, PRIMARY KEY(planning_id, subject_id), CONSTRAINT FK_26A363913D865311 FOREIGN KEY (planning_id) REFERENCES planning (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_26A3639123EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO planning_subject (planning_id, subject_id) SELECT planning_id, subject_id FROM __temp__planning_subject');
        $this->addSql('DROP TABLE __temp__planning_subject');
        $this->addSql('CREATE INDEX IDX_26A3639123EDC87 ON planning_subject (subject_id)');
        $this->addSql('CREATE INDEX IDX_26A363913D865311 ON planning_subject (planning_id)');
        $this->addSql('DROP INDEX IDX_80575E1B23EDC87');
        $this->addSql('DROP INDEX IDX_80575E1B8F5EA509');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe_subject AS SELECT classe_id, subject_id FROM classe_subject');
        $this->addSql('DROP TABLE classe_subject');
        $this->addSql('CREATE TABLE classe_subject (classe_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, PRIMARY KEY(classe_id, subject_id), CONSTRAINT FK_80575E1B8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_80575E1B23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO classe_subject (classe_id, subject_id) SELECT classe_id, subject_id FROM __temp__classe_subject');
        $this->addSql('DROP TABLE __temp__classe_subject');
        $this->addSql('CREATE INDEX IDX_80575E1B23EDC87 ON classe_subject (subject_id)');
        $this->addSql('CREATE INDEX IDX_80575E1B8F5EA509 ON classe_subject (classe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE info (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, link VARCHAR(255) NOT NULL COLLATE BINARY, filename VARCHAR(255) DEFAULT NULL COLLATE BINARY, updated_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, slug VARCHAR(255) NOT NULL COLLATE BINARY, title_ar VARCHAR(255) DEFAULT NULL COLLATE BINARY)');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP INDEX IDX_80575E1B8F5EA509');
        $this->addSql('DROP INDEX IDX_80575E1B23EDC87');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classe_subject AS SELECT classe_id, subject_id FROM classe_subject');
        $this->addSql('DROP TABLE classe_subject');
        $this->addSql('CREATE TABLE classe_subject (classe_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, PRIMARY KEY(classe_id, subject_id))');
        $this->addSql('INSERT INTO classe_subject (classe_id, subject_id) SELECT classe_id, subject_id FROM __temp__classe_subject');
        $this->addSql('DROP TABLE __temp__classe_subject');
        $this->addSql('CREATE INDEX IDX_80575E1B8F5EA509 ON classe_subject (classe_id)');
        $this->addSql('CREATE INDEX IDX_80575E1B23EDC87 ON classe_subject (subject_id)');
        $this->addSql('DROP INDEX IDX_169E6FB9EA000B10');
        $this->addSql('DROP INDEX IDX_169E6FB923EDC87');
        $this->addSql('DROP INDEX IDX_169E6FB9953C1C61');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course AS SELECT id, class_id, subject_id, source_id, title, video_url, added_at, published_at, start_time FROM course');
        $this->addSql('DROP TABLE course');
        $this->addSql('CREATE TABLE course (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, class_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, source_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, video_url VARCHAR(255) DEFAULT NULL, added_at DATETIME NOT NULL, published_at DATETIME NOT NULL, start_time TIME DEFAULT NULL)');
        $this->addSql('INSERT INTO course (id, class_id, subject_id, source_id, title, video_url, added_at, published_at, start_time) SELECT id, class_id, subject_id, source_id, title, video_url, added_at, published_at, start_time FROM __temp__course');
        $this->addSql('DROP TABLE __temp__course');
        $this->addSql('CREATE INDEX IDX_169E6FB9EA000B10 ON course (class_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB923EDC87 ON course (subject_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9953C1C61 ON course (source_id)');
        $this->addSql('DROP INDEX IDX_D8698A7623EDC87');
        $this->addSql('DROP INDEX IDX_D8698A768F5EA509');
        $this->addSql('DROP INDEX IDX_D8698A7612469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__document AS SELECT id, subject_id, classe_id, category_id, title, path, size, client_ip, updated_at, file_url, enabled FROM document');
        $this->addSql('DROP TABLE document');
        $this->addSql('CREATE TABLE document (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subject_id INTEGER NOT NULL, classe_id INTEGER NOT NULL, category_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, path VARCHAR(255) DEFAULT NULL, size VARCHAR(255) DEFAULT NULL, client_ip VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, file_url VARCHAR(255) DEFAULT NULL, enabled BOOLEAN DEFAULT NULL)');
        $this->addSql('INSERT INTO document (id, subject_id, classe_id, category_id, title, path, size, client_ip, updated_at, file_url, enabled) SELECT id, subject_id, classe_id, category_id, title, path, size, client_ip, updated_at, file_url, enabled FROM __temp__document');
        $this->addSql('DROP TABLE __temp__document');
        $this->addSql('CREATE INDEX IDX_D8698A7623EDC87 ON document (subject_id)');
        $this->addSql('CREATE INDEX IDX_D8698A768F5EA509 ON document (classe_id)');
        $this->addSql('CREATE INDEX IDX_D8698A7612469DE2 ON document (category_id)');
        $this->addSql('DROP INDEX IDX_D499BFF69C24126');
        $this->addSql('CREATE TEMPORARY TABLE __temp__planning AS SELECT id, day_id FROM planning');
        $this->addSql('DROP TABLE planning');
        $this->addSql('CREATE TABLE planning (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, day_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO planning (id, day_id) SELECT id, day_id FROM __temp__planning');
        $this->addSql('DROP TABLE __temp__planning');
        $this->addSql('CREATE INDEX IDX_D499BFF69C24126 ON planning (day_id)');
        $this->addSql('DROP INDEX IDX_EFA69DF93D865311');
        $this->addSql('DROP INDEX IDX_EFA69DF98F5EA509');
        $this->addSql('CREATE TEMPORARY TABLE __temp__planning_classe AS SELECT planning_id, classe_id FROM planning_classe');
        $this->addSql('DROP TABLE planning_classe');
        $this->addSql('CREATE TABLE planning_classe (planning_id INTEGER NOT NULL, classe_id INTEGER NOT NULL, PRIMARY KEY(planning_id, classe_id))');
        $this->addSql('INSERT INTO planning_classe (planning_id, classe_id) SELECT planning_id, classe_id FROM __temp__planning_classe');
        $this->addSql('DROP TABLE __temp__planning_classe');
        $this->addSql('CREATE INDEX IDX_EFA69DF93D865311 ON planning_classe (planning_id)');
        $this->addSql('CREATE INDEX IDX_EFA69DF98F5EA509 ON planning_classe (classe_id)');
        $this->addSql('DROP INDEX IDX_26A363913D865311');
        $this->addSql('DROP INDEX IDX_26A3639123EDC87');
        $this->addSql('CREATE TEMPORARY TABLE __temp__planning_subject AS SELECT planning_id, subject_id FROM planning_subject');
        $this->addSql('DROP TABLE planning_subject');
        $this->addSql('CREATE TABLE planning_subject (planning_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, PRIMARY KEY(planning_id, subject_id))');
        $this->addSql('INSERT INTO planning_subject (planning_id, subject_id) SELECT planning_id, subject_id FROM __temp__planning_subject');
        $this->addSql('DROP TABLE __temp__planning_subject');
        $this->addSql('CREATE INDEX IDX_26A363913D865311 ON planning_subject (planning_id)');
        $this->addSql('CREATE INDEX IDX_26A3639123EDC87 ON planning_subject (subject_id)');
    }
}

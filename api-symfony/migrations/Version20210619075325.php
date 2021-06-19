<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210619075325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, todolist_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, is_complete TINYINT(1) NOT NULL, INDEX IDX_527EDB25AD16642A (todolist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE todolist (id INT AUTO_INCREMENT NOT NULL, usertodo_id INT NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_DD4DF6DB767F408D (usertodo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25AD16642A FOREIGN KEY (todolist_id) REFERENCES todolist (id)');
        $this->addSql('ALTER TABLE todolist ADD CONSTRAINT FK_DD4DF6DB767F408D FOREIGN KEY (usertodo_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25AD16642A');
        $this->addSql('ALTER TABLE todolist DROP FOREIGN KEY FK_DD4DF6DB767F408D');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE todolist');
        $this->addSql('DROP TABLE `user`');
    }
}

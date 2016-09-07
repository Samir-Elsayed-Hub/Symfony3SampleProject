<?php

namespace Application\Migrations;

use AppBundle\Entity\Book;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160904185206 extends AbstractMigration implements ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $names  = [
            'Doctor With Big Eyes',
            'Hunger Of My Town',
            'Colleagues And Demons',
            'Humans In The Library',
            'Founders Of Evil',
            'Ancestor With Horns',
            'Age Of The Light',
            'Learning With The River',
            'Lord And Buffoon',
            'Beginning Of Perfection'
        ];

        $releaseDates = [
            '01.02.2016',
            '02.05.2016',
            '06.04.2015',
            '15.06.1982',
            '30.08.1530',
            '10.10.2019',
            '06.12.1923',
            '02.02.1965',
            '09.07.2001',
            '14.02.2002'
        ];

        $lengths = [
            200,
            10,
            30,
            600,
            900,
            1000,
            234,
            200,
            240,
            205,

        ];

        $genres = [
            'Police',
            'Comedy',
            'Drama',
            'Non­fiction Horror',
            'Drama',
            'Drama',
            'Tragedy',
            'Children Fiction',
            'Horror Satire',
            'Tragicomedy'
        ];

        $userReadables = [
            true,
            true,
            true,
            false,
            true,
            true,
            true,
            true,
            true,
            false
        ];

        for($i = 0; $i < 10; $i++) {
            $book = new Book();

            $book->setName($names[$i]);
            $book->setReleaseDate(new \DateTime($releaseDates[$i]));
            $book->setLength($lengths[$i]);
            $book->setGenres($genres[$i]);
            $book->setUserReadable($userReadables[$i]);

            $entityManager = $this->container->get('doctrine.orm.entity_manager');
            $entityManager->persist($book);
            $entityManager->flush();
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}

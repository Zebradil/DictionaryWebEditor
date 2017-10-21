<?php
declare(strict_types=1);

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Article;
use AppBundle\Entity\Dictionary;
use AppBundle\Entity\Meaning;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $dictionary = new Dictionary();
        $dictionary->setName('Соловарь морского языка')
            ->setDescription('Словарь включает в себя более 3000 единиц русского морского профессионального ' .
                'некодифицированного языка, который используется моряками и работниками береговых служб в ' .
                'неофициальном общении. В словаре фиксируются также лексические и фразеологические единицы, некогда ' .
                "широко употреблявшиеся моряками дореволюционной России и Советского Союза.\nДля специалистов в " .
                'области прикладного языкознания, когнитивной лингвистики и социолингвистики, переводчиков, ' .
                'редакторов и журналистов, студентов и аспирантов. Несомненный интерес вызовет книга и у читателей, ' .
                'профессионально связанных с флотом, организацией и обеспечением морских перевозок.');
        $manager->persist($dictionary);

        # article
        $article = new Article();
        $article->setTitle('абба́т, -а')
            ->setGrammar('м.')
            ->setDictionary($dictionary);
        $manager->persist($article);

        $meaning = new Meaning();
        $meaning->setCode('МЭС')
            ->setText('способ ведения морского боя в эпоху гребного и парусного флотов, заключавшийся в сближении ' .
                'кораблей вплотную с целью овладения ими посредством рукопашной схватки');
        $manager->persist($meaning);
        $article->addMeaning($meaning);

        $meaning = new Meaning();
        $meaning->setCode('Кор.')
            ->setStyle('вор., тюр. – лаг., ВМФ, особ. матрос., гражд. в. +')
            ->setText('физическое насилие над женщиной, изнасилование');
        $manager->persist($meaning);
        $article->addMeaning($meaning);
        $dictionary->addArticle($article);

        # article
        $article = new Article();
        $article->setTitle('авари́йщик, -а')
            ->setGrammar('м.')
            ->setDictionary($dictionary);
        $manager->persist($article);

        $meaning = new Meaning();
        $meaning->setText('член экипажа (матрос) аварийно-спасательного судна; член аварийной партии');
        $manager->persist($meaning);
        $article->addMeaning($meaning);
        $dictionary->addArticle($article);

        $manager->flush();
    }
}

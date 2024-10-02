<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Media;
use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Serie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {


        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
 





    private function createEpisodes(ObjectManager $manager, Season $season)
    {
        for ($j = 1; $j <= 10; $j++) { 
            $episode = new Episode();
            $episode->setSeason($season);
            $episode->setTitle('Episode ' . $j);
            $episode->setDuration(45); 
            $episode->setReleasedAt(new \DateTimeImmutable("+{$j} weeks"));
            $manager->persist($episode);
        }
    }
    private function createSeasons(ObjectManager $manager, Serie $serie) {
        for ($seasonNumber = 1; $seasonNumber <= 5; $seasonNumber++) {
            $season = new Season();
            $season->setSeries($serie);
            $season->setNumber($seasonNumber);

            $manager->persist($season);
            
        $this->createEpisodes($manager, $season);
    } 
    }

    



}
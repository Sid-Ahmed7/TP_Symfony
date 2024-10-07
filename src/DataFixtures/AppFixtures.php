<?php

namespace App\DataFixtures;

use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Language;
use App\Entity\Media;
use App\Entity\Serie;
use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{


    private array $languages = [];
    
    public function load(ObjectManager $manager): void
    {
        $this->languages[] = $this->createLanguages('English', 'en', $manager);
        $this->languages[] = $this->createLanguages('French', 'fr', $manager);
        $this->languages[] = $this->createLanguages('Spanish', 'es', $manager);
        $this->createMedia("Doctor Who", "serie",$manager);
        $this->createMedia("Fast and Furious", "movie",$manager);
        $manager->flush();
    }
 

    //Add episode 
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
    
    //Add season for serie
    private function createSeasons(ObjectManager $manager, Serie $serie) {
        for ($seasonNumber = 1; $seasonNumber <= 5; $seasonNumber++) {
            $season = new Season();
            $season->setSeries($serie);
            $season->setNumber($seasonNumber);
            $this->createEpisodes($manager, $season);
            $manager->persist($season);
            
        } 
    }

    //Create movie or serie
    private function createMedia(string $title, string $type, ObjectManager $manager): Media
    {
      
        if ($type === "serie") {

            $serie = new Serie();
            $serie->setTitle($title);
            $serie->setLongDescription("Longue description");
            $serie->setShortDescription("Short description");
            $serie->setCoverImage('http://');
            $serie->setReleaseDate(new \DateTime(datetime: "+7 days"));
            foreach ($this->languages as $language) {
                $serie->addLanguage($language);
            }
            $this->createSeasons($manager, $serie);
            $manager->persist($serie);

            return $serie;
            
        } elseif ($type === "movie") {
            
            $movie = new Movie();
            $movie->setTitle($title);
            $movie->setLongDescription("Longue description");
            $movie->setShortDescription("Short description");
            $movie->setCoverImage('http://');
            $movie->setReleaseDate(new \DateTime(datetime: "+7 days"));
            foreach ($this->languages as $language) {
                $movie->addLanguage($language);
            }
            $manager->persist(object: $movie);

            return $movie;


        } else {
            throw new \InvalidArgumentException("Type de média invalide : $type");
        }
    }

    //Add language for serie or movie
    private function createLanguages(string $nom, string $code, ObjectManager $manager): Language {
        $language = new Language();
        $language->setNom($nom);
        $language->setCode($code);
        $manager->persist($language);

        return $language;
    }




    



}
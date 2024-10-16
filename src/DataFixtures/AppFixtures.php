<?php

namespace App\DataFixtures;

use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Language;
use App\Entity\Media;
use App\Entity\Serie;
use App\Entity\Movie;
use App\Entity\Category;
use App\Entity\User;
use App\Entity\Subscription;
use App\Entity\SubscriptionHistory;
use App\Enum\UserAccountStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{


    private array $languages = [];
    private array $categories =[];
    private array $users = [];
    private array $subs = [];
    
    public function load(ObjectManager $manager): void
    {
        $this->createLanguages($manager);
        $this->createCategories($manager);
        $this->createMedia("Doctor Who", "serie",$manager);
        $this->createMedia("Fast and Furious", "movie",$manager);
        $this->createSubscriptions($manager);
        $this->createUser($this->subs, $manager);
        $this->createSubscriptionsHistory($this->users, $manager);
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
      $staff = [
        ['role' => 'Producteur', 'name' => 'Jean Dupont'],
        ['role' => 'Réalisateur', 'name' => 'Jean Dupont'],
        ['role' => 'Scénariste', 'name' => 'Jean Dupont'],
        ['role' => 'Cadreur', 'name' => 'Jean Dupont'],
        ['role' => 'Ingénieur du son', 'name' => 'Jean Dupont'],
        ['role' => 'Monteur', 'name' => 'Jean Dupont'],
      ];

    $cast = [
        ['role' => 'Acteur principal', 'name' => 'Acteur 1'],
        ['role' => 'Actrice principale', 'name' => 'Actrice 2'],
        ['role' => 'Acteur secondaire', 'name' => 'Acteur 3'],
    ];
    
        if ($type === "serie") {

            $serie = new Serie();
            $serie->setTitle($title);
            $serie->setLongDescription("Longue description de la serie");
            $serie->setShortDescription("Courte description de la serie");
            $serie->setCoverImage('http://');
            $serie->setReleaseDate(new \DateTime(datetime: "+7 days"));
            foreach ($this->languages as $language) {
                $serie->addLanguage($language);
            }
            foreach ($this->categories as $category) {
                $serie->addCategory($category);
            }
            $serie->setStaff($staff);
            $serie->setCasting($cast);
            $this->createSeasons($manager, $serie);
            $manager->persist($serie);

            return $serie;
            
        } elseif ($type === "movie") {
            
            $movie = new Movie();
            $movie->setTitle($title);
            $movie->setLongDescription("Longue description du film movie");
            $movie->setShortDescription("Courte description du film");
            $movie->setCoverImage('http://');
            $movie->setReleaseDate(new \DateTime(datetime: "+7 days"));
            foreach ($this->languages as $language) {
                $movie->addLanguage($language);
            }
            foreach ($this->categories as $category) {
                $movie->addCategory($category);
            }
            $movie->setStaff($staff);
            $movie->setCasting($cast);
            $manager->persist($movie);

            return $movie;


        } else {
            throw new \InvalidArgumentException("Invalid type media : $type");
        }
    }

    //Add language for serie or movie
    private function createLanguages(ObjectManager $manager) {
        $allLanguages =[
            ['name' => 'English', 'code' => 'en'],
            ['name' => 'French', 'code' => 'fr'],
            ['name' => 'Spanish', 'code' => 'es']
        ];

        $this->languages= [];
        
        foreach($allLanguages as $languages) {
            $language = new Language();
            $language->setName($languages['name']);
            $language->setCode($languages['code']);
            $manager->persist($language);
            $this->languages[] = $language;
        }
    
    }

    //Add category
    private function createCategories(ObjectManager $manager) {

        $allCategories =[
            ['name' => 'Action', 'label' => 'Action'],
            ['name' => 'Comedie', 'label' => 'Comedie']
        ];

        $this->categories = [];
        foreach ($allCategories as $categories) {
            $category = new Category();
            $category->setName($categories['name']);
            $category->setLabel($categories['label']);
            $manager->persist($category);
            $this->categories[] = $category;
        }
        
    }

    //Add User and return a list of users
    private function createUser(array $subs, ObjectManager $manager): array {
        $status = UserAccountStatusEnum::cases();
        $this->users = [];

        for($i = 0; $i < 5; $i++) {
             $user = new User();
             $user->setUsername("user" . $i);
             $user->setEmail($user->getUsername() . "@gmail.com");
             $user->setPassword("bonjour");
             $randomStatus = $status[array_rand($status)];
             $user->setAccountStatus($randomStatus);
             $randSub = $subs[array_rand($subs)];
             $user->setCurrentSubscription($randSub);
            $manager->persist($user);
            $this->users[] = $user;
        }

        return $this->users;
    }


    //Create Subscriptions
    private function createSubscriptions(ObjectManager $manager) : array {
       
       $this->subs = [];

        for($i = 0 ; $i < 5; $i++ ) {
            $sub = new Subscription();
            $sub->setName("Subscription" . $i);
            $sub->setPrice(10 +(10 * $i));
            $sub->setDuration(2);
            $manager->persist($sub);
            $this->subs[] = $sub;
        }

        return $this->subs;

    }

    //Create SubscriptionHistory
    private function createSubscriptionsHistory(array $users, ObjectManager $manager) {
        foreach ($users as $user) {

            $currentSubscription = $user->getCurrentSubscription();
            $subHistory = new SubscriptionHistory();
            $subHistory->setSubscriber($user);
            $subHistory->setSubscription($currentSubscription);
            $subHistory->setStartAt(new \DateTimeImmutable());
            $subHistory->setEndAt(new \DateTimeImmutable('+7 days'));
            $manager->persist($subHistory);
        }
    }


}
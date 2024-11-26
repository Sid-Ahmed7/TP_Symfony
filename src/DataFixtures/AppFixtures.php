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
use App\Entity\Playlist;
use App\Entity\PlaylistSubscription;
use App\Entity\PlaylistMedia;
use App\Entity\WatchHistory;
use App\Entity\Comment;
use App\Enum\UserAccountStatusEnum;
use App\Enum\CommentStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private array $languages = [];
    private array $categories =[];
    private array $users = [];
    private array $subs = [];
    private array $playlists = [];
    
    public function load(ObjectManager $manager): void
    {
        $this->createLanguages($manager);
        $this->createCategories($manager);
        //Create a serie
        $serie =  $this->createSerie($manager);
        //Create a movie
        $movie =  $this->createMovie($manager);
        $this->createSubscriptions($manager);
        $this->createUser($this->subs, $manager);
        $this->createSubscriptionsHistory($this->users, $manager);
        $this->createPlaylist($this->users, $manager);
        $this->createPlaylistSubscriptions($this->users, $manager);
        //Create a playlistMedia for a serie
        $this->createPlaylistMedia($serie, $this->playlists, $manager);
        //Create a playlistMedia for a movie
        $this->createPlaylistMedia($movie, $this->playlists, $manager);
        //Create a watchHistory for a serie
        $this->createWatchHistory($serie, $this->users, $manager);
        //Create a watchHistory for a movie
        $this->createWatchHistory($movie, $this->users, $manager);
        //Create a comment for a serie
        $this->createComment($serie, $this->users, $manager);
        //Create a comment for a movie
        $this->createComment($movie, $this->users, $manager);
        $manager->flush();
    }
 

    //Add episode 
    private function createEpisodes(ObjectManager $manager, Season $season)
    {
        for ($j = 0; $j <= 10; $j++) { 
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
        for ($seasonNumber = 0; $seasonNumber <= 5; $seasonNumber++) {
            $season = new Season();
            $season->setSeries($serie);
            $season->setNumber($seasonNumber);
            $this->createEpisodes($manager, $season);
            $manager->persist($season);
            
        } 
    }
     //Create serie
     private function createSerie(ObjectManager $manager): Media
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
     
     for($i = 0; $i < 5; $i++) {
        $serie = new Serie();
        $serie->setTitle("Film " . $i);
        $serie->setLongDescription("Longue description de la serie");
        $serie->setShortDescription("Courte description de la serie");
        $serie->setCoverImage('https://picsum.photos/400/550?random=' . $i);
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
    }
     return $serie;
 
     }

    //Create movie 
    private function createMovie(ObjectManager $manager): Media
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
    
        for($i = 0; $i < 5; $i++) {
            $movie = new Movie();
            $movie->setTitle("Movie " . $i);
            $movie->setLongDescription("Longue description du film movie");
            $movie->setShortDescription("Courte description du film");
            $movie->setCoverImage('https://picsum.photos/400/550?random=' . $i);
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

    //Create users
    private function createUser(array $subs, ObjectManager $manager): array {
        $status = UserAccountStatusEnum::cases();
        $this->users = [];

        for($i = 0; $i < 5; $i++) {
             $user = new User();
             $user->setUsername("user" . $i);
             $user->setEmail($user->getUsername() . "@gmail.com");
             $user->setPassword("bonjour");
             $user->setAccountStatus($status[array_rand($status)]);
             $user->setCurrentSubscription($subs[array_rand($subs)]);
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

    //Create Playlist
    private function createPlaylist(array $users, ObjectManager $manager) : array {
        $this->playlists = [];

        foreach ($users as $user) {
            
                $playlist = new Playlist();
                $playlist->setAuthor($user);
                $playlist->setName("Playlist " . $user->getUsername());
                $playlist->setCreatedAt(new \DateTimeImmutable());
                $playlist->setUpdatedAt(new \DateTimeImmutable());
                $user->addPlaylist($playlist);
                $manager->persist($playlist);
                $this->playlists[] = $playlist; 
                
            }
        return $this->playlists;
    }

    //Create playlist_subscriptions
    private function createPlaylistSubscriptions(array $users, ObjectManager $manager) {
        foreach ($users as $user) {
            
            $playlistSubscribers = $user->getPlaylists();

            foreach ($playlistSubscribers as $playlistSubscriber) {
                
            $playlistSub = new PlaylistSubscription();
            $playlistSub->setSubscriber($user);
            $playlistSub->setPlaylist($playlistSubscriber);
            $playlistSub->setSubscribedAt(new \DateTimeImmutable());
            
            }
            
            $manager->persist($playlistSub); 

        }

    }

    //Create playlistMedia
    private function createPlaylistMedia(Media $media, array $playlist, ObjectManager $manager) {
        $playlistMedia = new PlaylistMedia();
        $playlistMedia->setMedia($media);
        $playlistMedia->setAddedAt(addedAt: new \DateTimeImmutable());
        $playlistMedia->setPlaylist($playlist[array_rand($playlist)]);

        $manager->persist($playlistMedia);
    }

    //Create watch_history
    private function createWatchHistory(Media $media, array $users, ObjectManager $manager){
        foreach ($users as $user) {
            $watchHistory = new WatchHistory();
            $watchHistory->setMedia($media);
            $watchHistory->setWatcher($user);
            $watchHistory->setLastWatchedAt(new \DateTimeImmutable());
            $watchHistory->setNumberOfViews(rand(0, 10));

            $manager->persist($watchHistory);

        }
    }

    // Create comments
    private function createComment(Media $media, array $users, ObjectManager $manager){
        $commentStatus = CommentStatusEnum::cases();
        $nbUser = count($users);

        foreach ($users as $user) {

            for( $i = 0 ; $i < 2; $i++ ) {
                $comment = new Comment();
                $comment->setPublisher($user);
                $comment->setMedia($media);
                $comment->setStatus($commentStatus[array_rand($commentStatus)]);
                $comment->setContent("Comment " . chr(65 + $i / 2));

                $manager->persist($comment);

                $responseComment = new Comment();
                $responseComment->setPublisher($users[array_rand($users)]);
                $responseComment->setMedia($media);
                $responseComment->setContent("Response Comment " . chr(97 + $i / 2));
                $responseComment->setStatus($commentStatus[array_rand($commentStatus)]);
                $responseComment->setParentComment($comment);

                $manager->persist($responseComment);
            }
        }        

    }


}
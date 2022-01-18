<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('games')->insert([
            [
                //1
                'name' => "GTA V",
                'genre' => "Action",
                'picture' => 'public/images/GTAV.jpg',
                'video' => 'public/trailers/GTAVTrailer.webm',
                'description' => "Grand Theft Auto V for PC offers players the option to explore the award-winning world of Los Santos and Blaine County in resolutions of up to 4k and beyond, as well as the chance to experience the game running at 60 frames per second.",
                'longDescription' => "When a young street hustler, a retired bank robber and a terrifying psychopath find themselves entangled with some of the most frightening and deranged elements of the criminal underworld, the U.S. government and the entertainment industry, they must pull off a series of dangerous heists to survive in a ruthless city in which they can trust nobody, least of all each other. Grand Theft Auto V for PC offers players the option to explore the award-winning world of Los Santos and Blaine County in resolutions of up to 4k and beyond, as well as the chance to experience the game running at 60 frames per second.",
                'releaseDate' => date("2013/09/17"),//format date YYYY/MM/dd atau YYYY-MM-dd
                'developer' => "Rockstar",
                'publisher' => 'Rockstar',
                'price' => 560000,
                'adultsOnly' => true,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                //2
                'name' => "Dota 2",
                'genre' => "Strategy",
                'picture' => 'public/images/dota2.jpg',
                'video' => 'public/trailers/Dota2Trailer.webm',
                'description' => "Every day, millions of players worldwide enter battle as one of over a hundred Dota heroes. And no matter if it's their 10th hour of play or 1,000th, there's always something new to discover. With regular updates that ensure a constant evolution of gameplay, features, and heroes, Dota 2 has taken on a life of its own.",
                'longDescription' => "Every day, millions of players worldwide enter battle as one of over a hundred Dota heroes. And no matter if it's their 10th hour of play or 1,000th, there's always something new to discover. With regular updates that ensure a constant evolution of gameplay, features, and heroes, Dota 2 has taken on a life of its own.",
                'releaseDate' => date("2013/07/09"),//format date YYYY/MM/dd atau YYYY-MM-dd
                'developer' => "Valve",
                'publisher' => 'Valve',
                'price' => 0,
                'adultsOnly' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                //3
                'name' => "Apex Legends",
                'genre' => "Action",
                'picture' => 'public/images/ApexLegends.jpg',
                'video' => 'public/images/pic1.jpg',
                'description' => "Apex Legends is an online multiplayer battle royale game featuring squads of three players using pre-made characters with distinctive abilities, called \"Legends\"",
                'longDescription' => "Apex Legends is the award-winning, free-to-play Hero shooter from Respawn Entertainment. Master an ever-growing roster of legendary characters with powerful abilities and experience strategic squad play and innovative gameplay in the next evolution of Hero Shooter and Battle Royale.",
                'releaseDate' => date("2020/11/05"),//format date YYYY/MM/dd atau YYYY-MM-dd
                'developer' => "Respawn Entertainment",
                'publisher' => 'Electronic Arts',
                'price' => 0,
                'adultsOnly' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                //4
                'name' => "It Takes Two",
                'genre' => "Puzzle",
                'picture' => 'public/images/ItTakesTwo.jpg',
                'video' => 'public/images/pic1.jpg',
                'description' => "Embark on the craziest journey of your life in It Takes Two. Invite a friend to join for free with Friend’s Pass and work together across a huge variety of gleefully disruptive gameplay challenges.",
                'longDescription' => "Embark on the craziest journey of your life in It Takes Two, a genre-bending platform adventure created purely for co-op. Invite a friend to join for free with Friend’s Pass and work together across a huge variety of gleefully disruptive gameplay challenges. Play as the clashing couple Cody and May, two humans turned into dolls by a magic spell. Together, trapped in a fantastical world where the unpredictable hides around every corner, they are reluctantly challenged with saving their fractured relationship.",
                'releaseDate' => date("2021/03/26"),//format date YYYY/MM/dd atau YYYY-MM-dd
                'developer' => "Hazelight",
                'publisher' => 'Electronic Arts',
                'price' => 479000,
                'adultsOnly' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                //5
                'name' => "GTFO",
                'genre' => "Horror",
                'picture' => 'public/images/GTFO.jpg',
                'video' => 'public/trailers/GTFOTrailer.webm', //video
                'description' => "GTFO is a hardcore co-op FPS horror with high-intensity combat, tension-filled stealth, and team-based puzzle-solving for up to 4 players. In GTFO, you need to work together in order not to die together.",
                'longDescription' => "You and your team of prisoners must scavenge for tools and resources while looking for valuable artifacts in the depths of an abandoned underground Complex that is overrun by terrifying creatures. In GTFO, you must work together to complete the orders set down by a mysterious entity called The Warden - to make it out alive.",
                'releaseDate' => date("2021/03/10"),//format date YYYY/MM/dd atau YYYY-MM-dd
                'developer' => "Playground Games",
                'publisher' => 'Xbox Game Studios',
                'price' => 249000,
                'adultsOnly' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                //6
                'name' => "Forza Horizon 4",
                'genre' => "Sports",
                'picture' => 'public/images/ForzaHorizon4.jpg',
                'video' => 'public/images/pic1.jpg', //video
                'description' => "Dynamic seasons change everything at the world’s greatest automotive festival. Go it alone or team up with others to explore beautiful and historic Britain in a shared open world.",
                'longDescription' => "Dynamic seasons change everything at the world’s greatest automotive festival. Go it alone or team up with others to explore beautiful and historic Britain in a shared open world. Collect, modify and drive over 450 cars. Race, stunt, create and explore – choose your own path to become a Horizon Superstar.",
                'releaseDate' => date("2019/12/10"),//format date YYYY/MM/dd atau YYYY-MM-dd
                'developer' => "10 Chambers",
                'publisher' => '10 Chambers',
                'price' => 487000,
                'adultsOnly' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                //7
                'name' => "Monster Hunter World",
                'genre' => "Role-Playing",
                'picture' => 'public/images/MonsterHunterWorld.jpg',
                'video' => 'public/images/pic1.jpg', //video
                'description' => "Welcome to a new world! In Monster Hunter: World, the latest installment in the series, you can enjoy the ultimate hunting experience, using everything at your disposal to hunt monsters in a new world teeming with surprises and excitement.",
                'longDescription' => "Welcome to a new world! Take on the role of a hunter and slay ferocious monsters in a living, breathing ecosystem where you can use the landscape and its diverse inhabitants to get the upper hand. Hunt alone or in co-op with up to three other players, and use materials collected from fallen foes to craft new gear and take on even bigger, badder beasts!",
                'releaseDate' => date("2018/08/09"),//format date YYYY/MM/dd atau YYYY-MM-dd
                'developer' => "CAPCOM Co., Ltd.",
                'publisher' => 'CAPCOM Co., Ltd.',
                'price' => 334999,
                'adultsOnly' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                //8
                'name' => "Planet Coaster",
                'genre' => "Simulation",
                'picture' => 'public/images/PlanetCoaster.jpg',
                'video' => 'public/images/pic1.jpg', //video
                'description' => "Planet Coaster® - the future of coaster park simulation games has arrived! Surprise, delight and thrill incredible crowds as you build your coaster park empire - let your imagination run wild, and share your success with the world.",
                'longDescription' => "Welcome to a new world! Take on the role of a hunter and slay ferocious monsters in a living, breathing ecosystem where you can use the landscape and its diverse inhabitants to get the upper hand. Hunt alone or in co-op with up to three other players, and use materials collected from fallen foes to craft new gear and take on even bigger, badder beasts!",
                'releaseDate' => date("2016/11/17"),//format date YYYY/MM/dd atau YYYY-MM-dd
                'developer' => "Frontier Developments, Aspyr (MAC)",
                'publisher' => 'Frontier Developments, Aspyr (MAC)',
                'price' => 582095,
                'adultsOnly' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                //9
                'name' => "Totally Accurate Battle Simulator",
                'genre' => "Simulation",
                'picture' => 'public/images/TotallyAccurateBattleSimulator.jpg',
                'video' => 'public/images/pic1.jpg', //video
                'description' => "Be the leader of wobblers from ancient lands, spooky places, and fantasy worlds. Watch them fight in simulations made with the wobbliest physics system ever created, make your own wobblers in the unit creator and send your army off to fight your friends in multiplayer.",
                'longDescription' => "Welcome to a new world! Take on the role of a hunter and slay ferocious monsters in a living, breathing ecosystem where you can use the landscape and its diverse inhabitants to get the upper hand. Hunt alone or in co-op with up to three other players, and use materials collected from fallen foes to craft new gear and take on even bigger, badder beasts!",
                'releaseDate' => date("2021/04/02"),//format date YYYY/MM/dd atau YYYY-MM-dd
                'developer' => "Landfall",
                'publisher' => 'Landfall',
                'price' => 108999,
                'adultsOnly' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                //10
                'name' => "Phasmophobia",
                'genre' => "Horror",
                'picture' => 'public/images/phasmophobia.jpg',
                'video' => 'public/images/pic1.jpg', //video
                'description' => "Phasmophobia is a 4 player online co-op psychological horror. Paranormal activity is on the rise and it’s up to you and your team to use all the ghost hunting equipment at your disposal in order to gather as much evidence as you can.",
                'longDescription' => "Phasmophobia is a 4 player online co-op psychological horror where you and your team members of paranormal investigators will enter haunted locations filled with paranormal activity and gather as much evidence of the paranormal as you can. You will use your ghost hunting equipment to search for and record evidence of whatever ghost is haunting the location to sell onto a ghost removal team.",
                'releaseDate' => date("2020/09/19"),//format date YYYY/MM/dd atau YYYY-MM-dd
                'developer' => "Kinetic Games",
                'publisher' => 'Kinetic Games',
                'price' => 89999,
                'adultsOnly' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                //11
                'name' => "Left 4 Dead 2",
                'genre' => "Action",
                'picture' => 'public/images/Left4Dead2.jpg',
                'video' => 'public/images/pic1.jpg', //video
                'description' => "Set in the zombie apocalypse, Left 4 Dead 2 (L4D2) is the highly anticipated sequel to the award-winning Left 4 Dead, the #1 co-op game of 2008. This co-operative action horror FPS takes you and your friends through the cities, swamps and cemeteries of the Deep South, from Savannah to New Orleans",
                'longDescription' => "You'll play as one of four new survivors armed with a wide and devastating array of classic and upgraded weapons. In addition to firearms, you'll also get a chance to take out some aggression on infected with a variety of carnage-creating melee weapons, from chainsaws to axes and even the deadly frying pan.",
                'releaseDate' => date("2009/11/17"),//format date YYYY/MM/dd atau YYYY-MM-dd
                'developer' => "Valve",
                'publisher' => 'Valve',
                'price' => 69999,
                'adultsOnly' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                //12
                'name' => "Terraria",
                'genre' => "Adventure",
                'picture' => 'public/images/Terraria.jpg',
                'video' => 'public/images/pic1.jpg', //video
                'description' => "Dig, fight, explore, build! Nothing is impossible in this action-packed adventure game. Four Pack also available!",
                'longDescription' => "Dig, Fight, Explore, Build: The very world is at your fingertips as you fight for survival, fortune, and glory. Will you delve deep into cavernous expanses in search of treasure and raw materials with which to craft ever-evolving gear, machinery, and aesthetics? Perhaps you will choose instead to seek out ever-greater foes to test your mettle in combat? Maybe you will decide to construct your own city to house the host of mysterious allies you may encounter along your travels?",
                'releaseDate' => date("2011/05/17"),//format date YYYY/MM/dd atau YYYY-MM-dd
                'developer' => "Re-Logic",
                'publisher' => 'Re-Logic',
                'price' => 89999,
                'adultsOnly' => false,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
        ]);
    }
}

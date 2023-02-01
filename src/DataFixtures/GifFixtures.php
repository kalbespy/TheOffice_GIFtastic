<?php

namespace App\DataFixtures;

use App\Entity\Gif;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class GifFixtures extends Fixture
{
    public const GIFS = [
        [
            'title' => 'Dancing Andy',
            'picture' => 'AndyDance.gif',
        ],
        [
            'title' => 'BANKRUPTCY !',
            'picture' => 'Banckrupcy.gif',
        ],
        [
            'title' => 'Bear, Beets, Battlestar Galactica',
            'picture' => 'BearBeets.gif',
        ],
        [
            'title' => 'Tackle hug',
            'picture' => 'BigHug.gif',
        ],
        [
            'title' => 'It is your birthday',
            'picture' => 'Birthday.gif',
        ],
        [
            'title' => 'Save the cat',
            'picture' => 'CatFall.gif',
        ],
        [
            'title' => 'Dead Inside',
            'picture' => 'DeadInside.gif',
        ],
        [
            'title' => 'Stanley did not stutter...',
            'picture' => 'DidIStutter.gif',
        ],
        [
            'title' => 'Dwight Master of disguise',
            'picture' => 'DwightDisguise.gif',
        ],
        [
            'title' => 'Black belt dwight',
            'picture' => 'DwightKarate.gif',
        ],
        [
            'title' => 'Masked Dwight',
            'picture' => 'DwightMask.gif',
        ],
        [
            'title' => 'Screaming Dwight ',
            'picture' => 'DwightScream.gif',
        ],
        [
            'title' => 'KGB will wait for no-one !',
            'picture' => 'DwightTrue.gif',
        ],
        [
            'title' => 'Victorious Dwight',
            'picture' => 'DwightVictory.gif',
        ],
        [
            'title' => 'Finger Zipper',
            'picture' => 'FingerZipper.gif',
        ],
        [
            'title' => 'Fire in the hole !',
            'picture' => 'Fire in the hole.gif',
        ],
        [
            'title' => 'God, please No !',
            'picture' => 'GodNo.gif',
        ],
        [
            'title' => 'Hockey Toby',
            'picture' => 'HockeyToby.gif',
        ],
        [
            'title' => 'I\'ll kill you',
            'picture' => 'I\'ll kill you.gif',
        ],
        [
            'title' => 'Classic Jim Prank',
            'picture' => 'Jello.gif',
        ],
        [
            'title' => 'Oh..',
            'picture' => 'JimFace.gif',
        ],
        [
            'title' => 'Incognito Jim',
            'picture' => 'JimHidden.gif',
        ],
        [
            'title' => 'Kevin nods and smile',
            'picture' => 'Kevin-Nods-and-Smiles.gif',
        ],
        [
            'title' => 'Kevin Best Chili',
            'picture' => 'KevinChili.gif',
        ],
        [
            'title' => 'Kevin laughing',
            'picture' => 'KevinLaugh.gif',
        ],
        [
            'title' => 'Mexican standoff',
            'picture' => 'MexicanStandoff.gif',
        ],
        [
            'title' => 'Fire panic',
            'picture' => 'MichaelHappening.gif',
        ],
        [
            'title' => 'Festive Michael',
            'picture' => 'MichealFest.gif',
        ],
        [
            'title' => 'Parkour',
            'picture' => 'Parkour.gif',
        ],
        [
            'title' => 'Prison Mike',
            'picture' => 'PrisonMike.gif'
        ],
        [
            'title' => 'Prison Mike Story',
            'picture' => 'PrisonMikeDementors.gif'
        ],
        [
            'title' => 'Michael hates Toby',
            'picture' => 'SmashFace.gif'
        ],
        [
            'title' => 'Stanley Eyeroll',
            'picture' => 'StanleyEyeRoll.gif'
        ],
        [
            'title' => 'Thank you',
            'picture' => 'ThankYou.gif'
        ],
        [
            'title' => 'That\'s what he said',
            'picture' => 'ThatsWhatHeSaid.gif'
        ],
        [
            'title' => 'That\'s what she said',
            'picture' => 'ThatsWhatSheSaid.gif',
        ],
        [
            'title' => 'Unbelievable',
            'picture' => 'Unbelievable.gif',
        ],
        [
            'title' => 'This guy',
            'picture' => 'ThisGuy.gif',
        ],
        [
            'title' => 'This is the worst',
            'picture' => 'ThisIsTheWorst.gif',
        ],
        [
            'title' => 'Michael still hates Toby',
            'picture' => 'TobyNobodyCares.gif',
        ],
        [
            'title' => 'Michael try to hide his feeling',
            'picture' => 'WorstEnd.gif',
        ],
        [
            'title' => 'Yes Dwight',
            'picture' => 'YesDwight.gif',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        foreach (self::GIFS as $key => $values) {
            $gif = new Gif();
            $gif->setTitle($values['title']);
            $gif->setPicture($values['picture']);
            $gif->setNbOfVotes($faker->numberBetween(0, 5000));
            $manager->persist($gif);
            $this->addReference('gif_' . $key, $gif);
        }
        $manager->flush();
    }
}

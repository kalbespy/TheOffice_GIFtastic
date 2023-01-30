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
            'title' => 'Tackle hug',
            'picture' => 'BigHug.gif',
            'nbOfVotes' => '654'
        ],
        [
            'title' => 'Finger Zipper',
            'picture' => 'Blague-doigt.gif',
        ],
        [
            'title' => 'Screaming Dwight',
            'picture' => 'Dwight_scream.gif',
        ],
        [
            'title' => 'Fire in the hole !',
            'picture' => 'Fire in the hole.gif',
        ],
        [
            'title' => 'I\'ll kill you',
            'picture' => 'I\'ll kill you.gif',
        ],
        [
            'title' => 'Kevin nods and smile',
            'picture' => 'Kevin-Nods-and-Smiles-The-Office.gif',
        ],
        [
            'title' => 'Bankrupcy declaration!',
            'picture' => 'Michael-Scott-I-Declare-Bankruptcy.gif',
        ],
        [
            'title' => 'That\'s what she said',
            'picture' => 'That\'s what she said.gif',
        ],
        [
            'title' => 'Unbelievable',
            'picture' => 'The-Office-Interview-Unbelievable.gif',
        ],
        [
            'title' => 'This guy',
            'picture' => 'This-Guy-Jim-Halpert-The-Office.gif',
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        foreach (self::GIFS as $key => $values) {
            $gif = new Gif();
            $gif->setTitle($values['title']);
            $gif->setPicture($values['picture']);
            $gif->setNbOfVotes(($faker->numberBetween(0, 5000)));
            $manager->persist($gif);
            $this->addReference('gif_' . $key, $gif);
        }
        $manager->flush();
    }
}

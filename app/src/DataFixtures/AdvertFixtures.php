<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdvertFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $advert = new Advert();
        $advert->setTitle('Test title');
        $advert->setDescription('Test Descritption');
        $advert->setPrice(100);
        $advert->setZipCode(75001);
        $advert->setSaleCity('Paris');
        $manager->persist($advert);

        $manager->flush();
    }


    public static function getAdvertContentWithoutError(): array
    {
        return [
            'title' => 'Advert title',
            'description' => 'Advert description',
            'price' => 'Advert price',
            'zip_code' => 'Advert zip code',
            'sale_country' => 'Advert sale country',
        ];
    }

    public static function getAdvertContentWithMissingProperty(): array
    {
        return [
            'title' => 'Advert title',
            'price' => 'Advert price',
            'zip_code' => 'Advert zip code',
            'sale_country' => 'Advert sale country',
        ];
    }


}

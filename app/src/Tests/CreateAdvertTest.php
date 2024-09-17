<?php
declare(strict_types=1);

namespace App\Tests;

use App\DataFixtures\AdvertFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateAdvertTest extends WebTestCase
{
    public function testCreateAdvertSuccess(): void
    {
        $client = static::createClient();
        $client->request(
            method:'POST',
            uri:'/advert',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode(AdvertFixtures::getAdvertContentWithoutError(), JSON_THROW_ON_ERROR),        );

        $this->assertResponseIsSuccessful();
    }

    public function testCreateAdvertWithMissingProperty(): void
    {
        $client = static::createClient();
        $client->request(
            method:'POST',
            uri:'/advert',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode(AdvertFixtures::getAdvertContentWithMissingProperty(), JSON_THROW_ON_ERROR),        );

        $this->assertSame(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }
}
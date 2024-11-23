<?php
namespace App\Service;

use MongoDB\Client;

class MongoDBService
{
    private $client;
    private $database;

    public function __construct(string $mongoUrl, string $databaseName)
    {
        $this->client = new Client(uri: $mongoUrl);
        $this->database = $this->client->selectDatabase($databaseName);
    }

    public function getCollection(string $collectionName)
    {
        return $this->database->selectCollection($collectionName);
    }


}
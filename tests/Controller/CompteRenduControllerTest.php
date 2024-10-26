<?php

namespace App\Tests\Controller;

use App\Entity\CompteRendu;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CompteRenduControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/compte/rendu/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(CompteRendu::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('CompteRendu index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'compte_rendu[date]' => 'Testing',
            'compte_rendu[etat_animal]' => 'Testing',
            'compte_rendu[grammage]' => 'Testing',
            'compte_rendu[detail]' => 'Testing',
            'compte_rendu[animal]' => 'Testing',
            'compte_rendu[user]' => 'Testing',
            'compte_rendu[nourriture]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new CompteRendu();
        $fixture->setDate('My Title');
        $fixture->setEtat_animal('My Title');
        $fixture->setGrammage('My Title');
        $fixture->setDetail('My Title');
        $fixture->setAnimal('My Title');
        $fixture->setUser('My Title');
        $fixture->setNourriture('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('CompteRendu');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new CompteRendu();
        $fixture->setDate('Value');
        $fixture->setEtat_animal('Value');
        $fixture->setGrammage('Value');
        $fixture->setDetail('Value');
        $fixture->setAnimal('Value');
        $fixture->setUser('Value');
        $fixture->setNourriture('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'compte_rendu[date]' => 'Something New',
            'compte_rendu[etat_animal]' => 'Something New',
            'compte_rendu[grammage]' => 'Something New',
            'compte_rendu[detail]' => 'Something New',
            'compte_rendu[animal]' => 'Something New',
            'compte_rendu[user]' => 'Something New',
            'compte_rendu[nourriture]' => 'Something New',
        ]);

        self::assertResponseRedirects('/compte/rendu/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getEtat_animal());
        self::assertSame('Something New', $fixture[0]->getGrammage());
        self::assertSame('Something New', $fixture[0]->getDetail());
        self::assertSame('Something New', $fixture[0]->getAnimal());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getNourriture());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new CompteRendu();
        $fixture->setDate('Value');
        $fixture->setEtat_animal('Value');
        $fixture->setGrammage('Value');
        $fixture->setDetail('Value');
        $fixture->setAnimal('Value');
        $fixture->setUser('Value');
        $fixture->setNourriture('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/compte/rendu/');
        self::assertSame(0, $this->repository->count([]));
    }
}

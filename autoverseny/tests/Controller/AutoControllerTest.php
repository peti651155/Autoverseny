<?php

namespace App\Test\Controller;

use App\Entity\Auto;
use App\Repository\AutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AutoControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AutoRepository $repository;
    private string $path = '/kocsi/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Auto::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Auto index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'auto[model]' => 'Testing',
            'auto[manufactureYear]' => 'Testing',
            'auto[power]' => 'Testing',
            'auto[weight]' => 'Testing',
            'auto[deletedAt]' => 'Testing',
        ]);

        self::assertResponseRedirects('/kocsi/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Auto();
        $fixture->setModel('My Title');
        $fixture->setManufactureYear('My Title');
        $fixture->setPower('My Title');
        $fixture->setWeight('My Title');
        $fixture->setDeletedAt('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Auto');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Auto();
        $fixture->setModel('My Title');
        $fixture->setManufactureYear('My Title');
        $fixture->setPower('My Title');
        $fixture->setWeight('My Title');
        $fixture->setDeletedAt('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'auto[model]' => 'Something New',
            'auto[manufactureYear]' => 'Something New',
            'auto[power]' => 'Something New',
            'auto[weight]' => 'Something New',
            'auto[deletedAt]' => 'Something New',
        ]);

        self::assertResponseRedirects('/kocsi/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getModel());
        self::assertSame('Something New', $fixture[0]->getManufactureYear());
        self::assertSame('Something New', $fixture[0]->getPower());
        self::assertSame('Something New', $fixture[0]->getWeight());
        self::assertSame('Something New', $fixture[0]->getDeletedAt());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Auto();
        $fixture->setModel('My Title');
        $fixture->setManufactureYear('My Title');
        $fixture->setPower('My Title');
        $fixture->setWeight('My Title');
        $fixture->setDeletedAt('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/kocsi/');
    }
}

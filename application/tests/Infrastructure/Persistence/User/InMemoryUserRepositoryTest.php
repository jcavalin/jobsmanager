<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\User;

use App\Domain\Job\Job;
use App\Domain\User\UserNotFoundException;
use App\Infrastructure\Persistence\Job\InMemoryJobRepository;
use Tests\TestCase;

class InMemoryUserRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $user = new Job(1, 'bill.gates', 'Bill', 'Gates');

        $userRepository = new InMemoryJobRepository([1 => $user]);

        $this->assertEquals([$user], $userRepository->findAll());
    }

    public function testFindAllUsersByDefault()
    {
        $users = [
            1 => new Job(1, 'bill.gates', 'Bill', 'Gates'),
            2 => new Job(2, 'steve.jobs', 'Steve', 'Jobs'),
            3 => new Job(3, 'mark.zuckerberg', 'Mark', 'Zuckerberg'),
            4 => new Job(4, 'evan.spiegel', 'Evan', 'Spiegel'),
            5 => new Job(5, 'jack.dorsey', 'Jack', 'Dorsey'),
        ];

        $userRepository = new InMemoryJobRepository();

        $this->assertEquals(array_values($users), $userRepository->findAll());
    }

    public function testFindUserOfId()
    {
        $user = new Job(1, 'bill.gates', 'Bill', 'Gates');

        $userRepository = new InMemoryJobRepository([1 => $user]);

        $this->assertEquals($user, $userRepository->findUserOfId(1));
    }

    public function testFindUserOfIdThrowsNotFoundException()
    {
        $userRepository = new InMemoryJobRepository([]);
        $this->expectException(UserNotFoundException::class);
        $userRepository->findUserOfId(1);
    }
}

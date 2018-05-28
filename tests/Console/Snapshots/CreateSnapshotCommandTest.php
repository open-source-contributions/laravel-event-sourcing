<?php

namespace Spatie\EventProjector\Console\Snapshots;

use Illuminate\Support\Facades\Storage;
use Spatie\EventProjector\Facades\EventProjectionist;
use Spatie\EventProjector\Snapshots\SnapshotRepository;
use Spatie\EventProjector\Tests\TestCase;
use Spatie\EventProjector\Tests\TestClasses\Models\Account;
use Spatie\EventProjector\Tests\TestClasses\Projectors\SnapshottableProjector;

class CreateSnapshotCommandTest extends TestCase
{
    /** @var \Spatie\EventProjector\Tests\TestClasses\Models\Account */
    protected $account;

    public function setUp()
    {
        parent::setUp();

        Storage::fake();

        $this->account = Account::create([
            'name' => 'John',
            'amount' => 1000,
        ]);
    }

    /** @test */
    public function it_can_create_a_snapshot()
    {
        EventProjectionist::addProjector(SnapshottableProjector::class);

        $this->artisan('event-projector:create-snapshot', [
            'projectorName' => SnapshottableProjector::class
        ]);

        $allSnapshots = app(SnapshotRepository::class)->get();

        $this->assertCount(1, $allSnapshots);


    }
}

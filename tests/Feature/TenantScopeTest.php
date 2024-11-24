<?php

use App\Models\Tenant;
use App\Models\User;
use function Pest\Laravel\actingAs;

test('a model has a tenant id on the migration', function () {
    $now = now();
    $this->artisan('make:model Test -m');

    // find the migration file and check it has a tenant_id on it
    $filename = $now->format('Y_m_d_His') . '_create_tests_table.php';
    $this->assertTrue(File::exists(database_path('migrations/' . $filename)));

    // check the migration file
    $this->assertStringContainsString('$table->unsignedBigInteger(\'tenant_id\')->index();',
        File::get(database_path('migrations/' . $filename)));

    // clean up
    File::delete(database_path('migrations/' . $filename));
    File::delete(app_path('Models/Test.php'));
});

test('a user can only see users in the same tenant', function () {
    $tenant1 = Tenant::factory()->create();
    $tenant2 = Tenant::factory()->create();

    $user1 = User::factory()->create(['tenant_id' => $tenant1->id]);
    User::factory(9)->create(['tenant_id' => $tenant1->id]);
    User::factory(10)->create(['tenant_id' => $tenant2->id]);

    actingAs($user1)->session([
        'tenant_id' => $tenant1->id
    ]);

    $this->assertEquals(10, User::count());
});

test('a user can only create a user in his tenant', function () {
    $tenant1 = Tenant::factory()->create();
    $tenant2 = Tenant::factory()->create();

    $user1 = User::factory()->create(['tenant_id' => $tenant1->id]);

    actingAs($user1)->session([
        'tenant_id' => $tenant1->id,
    ]);

    $createdUser = User::factory()->create();

    $this->assertSame($createdUser->tenant_id, $user1->tenant_id);
});

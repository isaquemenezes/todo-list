<?php
namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_see_users_index()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)
            ->get(route('admin.users.index'));

        $response->assertStatus(200);

        $response->assertSee($user->name);
        $response->assertSee($user->email);
    }

    public function test_non_admin_cannot_access_users_index()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertForbidden();
    }


}

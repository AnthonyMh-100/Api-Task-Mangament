<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_create_task(): void
    {
        $user = User::create([
            'name' => 'Anthony',
            'email' => 'tony@gmail.com',
            'password' => bcrypt('tony123')
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->postJson('api/tasks', [
            "title" => "Nueva de test",
            "description" => "Descripcion test",
            "status" => "pending"
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('tasks', [
            "title" => "Nueva de test",
            "description" => "Descripcion test",
            "status" => "pending"
        ]);

    }

    public function test_update_task()
    {
        $user = User::create([
            'name' => 'Anthony',
            'email' => 'tony@gmail.com',
            'password' => bcrypt('tony123')
        ]);

        $token = JWTAuth::fromUser($user);

        $task = Task::create([
            'title' => 'Tarea test',
            'description' => 'Descripción test',
            'status' => 'pending',
            'user_id' => $user->id,
        ]);

        $updatedData = [
            'title' => 'Tarea test actualizada',
            'description' => 'Descripción test actualizada',
            'status' => 'done',
        ];

        $response = $this->putJson('api/tasks/' . $task->id, $updatedData, [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertOk();
    }

    public function test_delete_task()
    {
        $user = User::create([
            'name' => 'Anthony',
            'email' => 'tony@gmail.com',
            'password' => bcrypt('tony123')
        ]);

        $token = JWTAuth::fromUser($user);

        $task = Task::create([
            'title' => 'Tarea test para eliminar',
            'description' => 'Descripción test para eliminar',
            'status' => 'pending',
            'user_id' => $user->id,
        ]);

        $response = $this->deleteJson('api/tasks/' . $task->id, [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_get_task(): void
    {
        $user = User::create([
            'name' => 'Anthony',
            'email' => 'tony@gmail.com',
            'password' => bcrypt('tony123')
        ]);

        $token = JWTAuth::fromUser($user);

        $task = Task::create([
            'title' => 'Tarea de test',
            'description' => 'Descripción de la tarea de test',
            'status' => 'pending',
            'user_id' => $user->id,
        ]);

        $response = $this->getJson('api/tasks/' . $task->id, [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertOk();
    }

}

<?php

namespace Tests\Feature;

use App\Domain\Book\Models\Book;
use App\Domain\Store\Models\Store;
use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    private $rota = '/api/stores';
    private $repository_structure = [];
    private $repository_structure_failure = [];
    private $data_structure = [];
    private $access_token = '';
    private $authorization = [];

    public function setUp(): void {
        parent::setUp();
        $this->initDatabase();
        $this->initGlobals();
        $this->getAuthorization();
    }

    public function initDatabase(): void {
        // Configura banco na memoria
        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => ':memory:']);
        config(['database.connections.mysql.foreign_key_constraints' => false]);

        // Roda migrations
        Artisan::call('migrate');
        // Roda seeds
        Artisan::call('db:seed');

        // Dados retornados na model
        $this->data_structure = [
            'name',
            'address',
            'active'
        ];
    }

    public function initGlobals(): void {
        // Dados retornados pelo repository
        $this->repository_structure = [
            'success',
            'data' => [],
            'message',
            'metadata' => []
        ];

        $this->repository_structure_failure = [
            'success',
            'debug' => [],
            'message'
        ];
    }

    public function getAuthorization() : void
    {
        $token = JWTAuth::fromUser(
            User::find(1)
        );

        $this->access_token = $token;

        $this->authorization = [
            'Authorization' => 'Bearer '.$this->access_token
        ];
    }

    /** @test */
    public function checkGetStores(): void
    {
        $response = $this->json('get', $this->rota, [], $this->authorization);

        $structure = $this->repository_structure;
        $structure['data'][] = $this->data_structure;

        $response->assertJsonStructure($structure);
        $response->assertStatus(Response::HTTP_OK);
    }
    /** @test */
    public function checkGetStore(): void
    {
        $rota = $this->rota.'/1';
        $response = $this->json('get', $rota, [], $this->authorization);

        $structure = $this->repository_structure;
        $structure['data'] = $this->data_structure;

        $response->assertJsonStructure($structure);
        $response->assertStatus(Response::HTTP_OK);
    }
    /** @test */
    public function checkGetStoreFailure(): void
    {
        $rota = $this->rota.'/0';
        $response = $this->json('get', $rota, [], $this->authorization);

        $response->assertJsonStructure($this->repository_structure_failure);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
    /** @test */
    public function checkDeleteStore(): void
    {
        $data = Store::inRandomOrder()->firstOrFail();
        $rota = $this->rota.'/'.$data['id'];

        $response = $this->json('delete', $rota, [], $this->authorization);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
    /** @test */
    public function checkDeleteStoreFailure(): void
    {
        $data = Store::orderBy('id', 'desc')->first();
        $rota = $this->rota.'/'.($data['id']+1);

        $response = $this->json('delete', $rota, [], $this->authorization);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
    /** @test */
    public function checkStoreStore(): void
    {
        $book = Book::factory()->create();

        $content = [
            'name' =>  $this->faker->company(),
            'address' => $this->faker->address(),
            'active' => $this->faker->boolean(),
            'books_id' => [$book->id]
        ];
        $response = $this->json('post', $this->rota, $content, $this->authorization);

        $response->assertStatus(Response::HTTP_CREATED);
    }
    /** @test */
    public function checkStoreStoreFailure(): void
    {
        $content = [
            'name' =>  $this->faker->company(),
            'address' => $this->faker->address(),
            'active' => $this->faker->boolean(),
            'books_id' => $this->faker->sentence(5)
        ];
        $response = $this->json('post', $this->rota, $content, $this->authorization);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    /** @test */
    public function checkUpdateStore(): void
    {
        $data = Store::inRandomOrder()->firstOrFail();
        $rota = $this->rota.'/'.$data['id'];
        $content = [
            'name' =>  $this->faker->company(),
            'address' => $this->faker->address(),
            'active' => $this->faker->boolean(),
        ];

        $response = $this->json('put', $rota, $content, $this->authorization);

        $response->assertStatus(Response::HTTP_OK);
    }
    /** @test */
    public function checkUpdateStoreFailure(): void
    {
        $data = Store::orderBy('id', 'desc')->first();
        $rota = $this->rota.'/'.$data['id']+1;
        $content = [
            'name' =>  $this->faker->company(),
            'address' => $this->faker->address(),
            'active' => $this->faker->boolean(),
        ];

        $response = $this->json('put', $rota, $content, $this->authorization);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}

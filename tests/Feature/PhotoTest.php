<?php

namespace Tests\Feature;

use App\Models\Photo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PhotoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_get_photos()
    {
        Photo::factory(10)->create();

        $response = $this->getJson(route('photo.index'));

        $response->assertStatus(200)
                 ->assertJsonCount(10, 'data');
    }

    public function test_user_can_post_photos()
    {
        $photo = Photo::factory()->make();
        $input['caption']=$photo->caption;
        $input['tags'] = $photo->tags;
        $input['file'] = UploadedFile::fake()->image(time().'.jpg', 480, 480);

        $response = $this->actingAs($this->user)->postJson(route('photo.store'), $input);

        $response->assertStatus(201)
                ->assertJson(['caption'=>$photo->caption]);

        $this->assertDatabaseHas('photos', [
            'id'=>$response->json('id')
        ]);
    }

    public function test_user_can_get_one_photos()
    {
        $photo = Photo::factory()->create();

        $response = $this->getJson(route('photo.show', $photo->id));

        $response->assertStatus(200)
                ->assertJson($photo->only('path','file_name'));
    }

    public function test_user_can_update_photos()
    {
        $photo = Photo::factory()->create();
        $input['caption']='new caption';
        $input['tags'] = ['tags'];

        $response = $this->actingAs($this->user)->putJson(route('photo.update', $photo->id), $input);

        $response->assertStatus(200)
                ->assertJson(['caption'=>$input['caption']]);

        $this->assertDatabaseHas('photos', [
            'caption'=>$input['caption']
        ]);
    }

    public function test_user_can_delete_photos()
    {
        $photo = Photo::factory()->make();
        $input['caption']=$photo->caption;
        $input['tags'] = $photo->tags;
        $input['file'] = UploadedFile::fake()->image(time().'.jpg', 480, 480);

        $id = $this->actingAs($this->user)->postJson(route('photo.store'), $input)->json('id');

        $response = $this->actingAs($this->user)->deleteJson(route('photo.destroy', $id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('photos', [
            'id'=>$id
        ]);
    }

    public function test_user_can_like_photos()
    {
        $photo = Photo::factory()->create();

        $response = $this->actingAs($this->user)->postJson(route('photo.like', $photo->id));

        $response->assertStatus(201);
    }

    public function test_user_can_unlike_photos()
    {
        $photo = Photo::factory()->create();

        $response = $this->actingAs($this->user)->postJson(route('photo.unlike', $photo->id));

        $response->assertStatus(204);
    }
}

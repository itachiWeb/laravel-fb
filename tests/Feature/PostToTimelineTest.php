<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostToTimelineTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_post_a_text_post()
    {
        $this->withoutExceptionHandling();
        //参考:https://qiita.com/Fea/items/7d70caa52e73c3fd8dfe
        $this->actingAs($user = factory(User::class)->create(), 'api');
        //use App\User; を追記したため、\App\を省略できる。

        $response = $this->post('/api/posts', [
            'data' => [
                'type' => 'posts',
                'attributes' => [
                    'body' => 'Testing Body',
                ]
            ]
        ]);

        $post = \App\Post::first();

        $response->assertStatus(201);
    }
}

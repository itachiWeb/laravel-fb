<?php

namespace Tests\Feature;

use App\User;
use App\Post;
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
        //ここで新規ユーザーを作成しています。（おそらく）
        //5行目にuse App\User; を追記したため、\App\を省略できる。

        $response = $this->post('/api/posts', [
            'data' => [
                'type' => 'posts',
                'attributes' => [
                    'body' => 'Testing Body',
                ]
            ]
        ]);

        // $post = \App\Post::first(); 5行目にuse App\User;と記載しているため、\App\は不要。
        $post = Post::first();

        $this->assertCount(1, Post::all());
        //一致していなければエラーを返す
        $this->assertEquals($user->id, $post->user_id);
        $this->assertEquals('Testing Body', $post->body);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'type' => 'posts',
                    'post_id' => $post->id,
                    'attributes' => [
                        'posted_by' => [
                            'data' => [
                                'attributes' => [
                                    'name' => $user->name,
                                ]
                            ]
                        ],
                        'body' => 'Testing Body',
                    ]
                ],
                'links' => [
                    'self' => url('/posts/'.$post->id),
                ]

        ]);
    }
}

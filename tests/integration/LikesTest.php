<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LikesTest extends TestCase
{
    use DatabaseTransactions;

     /** @test */
    public function a_user_can_like_a_post()
    {
        $post = factory(App\Post::class)->create();
        $user = factory(App\User::class)->create();

        // actingAs 輔助方法提供了簡單的方式，讓指定的使用者認證為當前的使用者
        $this->actingAs($user);

        $post->like();

        // seeInDatabase 輔助方法，來斷言資料庫中是否存在與指定條件互相匹配的資料
        $this->seeInDatabase('likes',[
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post),
        ]);

        $this->assertTrue($post->isLiked());
    }

    /** @test */
    public function a_user_can_unlike_a_post()
    {
        $post = factory(App\Post::class)->create();
        $user = factory(App\User::class)->create();

        $this->actingAs($user);

        $post->like();
        $post->unlike();

        $this->notSeeInDatabase('likes',[
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post),
        ]);

        $this->assertFalse($post->isLiked());
    }

    /** @test */
    public function a_user_may_toggle_a_posts_like_status()
    {
        $post = factory(App\Post::class)->create();
        $user = factory(App\User::class)->create();

        $this->actingAs($user);

        $post->toggle();

        $this->assertTrue($post->isLiked());
    }

    /** @test */
    public function a_post_knows_how_many_likes_it_has()
    {

        $post = factory(App\Post::class)->create();
        $user = factory(App\User::class)->create();

        $this->actingAs($user);

        $post->toggle();

        // $post->likesCount 定義一個存取器
        // https://laravel.tw/docs/5.1/eloquent-mutators
        $this->assertEquals(1,$post->likesCount);
    }

}
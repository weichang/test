<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LikesTest extends TestCase
{
    use DatabaseTransactions;
    protected $post;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        //$this->post = factory(App\Post::class)->create();
        $this->post = createPost();
        $this->signIn();
    }

    /** @test */
    public function a_user_can_like_a_post()
    {
        $this->post->like();

        // seeInDatabase 輔助方法，來斷言資料庫中是否存在與指定條件互相匹配的資料
        $this->seeInDatabase('likes',[
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post),
        ]);

        $this->assertTrue($this->post->isLiked());
    }

    /** @test */
    public function a_user_can_unlike_a_post()
    {
        $this->post->like();
        $this->post->unlike();

        $this->notSeeInDatabase('likes',[
            'user_id' =>  $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post),
        ]);

        $this->assertFalse($this->post->isLiked());
    }

    /** @test */
    public function a_user_may_toggle_a_posts_like_status()
    {

        $this->post->toggle();

        $this->assertTrue($this->post->isLiked());
    }

    /** @test */
    public function a_post_knows_how_many_likes_it_has()
    {

        $this->post->toggle();

        // $post->likesCount 定義一個存取器
        // https://laravel.tw/docs/5.1/eloquent-mutators
        $this->assertEquals(1,$this->post->likesCount);
    }

}
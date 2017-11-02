<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Team;
use App\User;

class TeamTest extends TestCase
{
    use DatabaseTransactions;

    // 測試 隊伍命名
    public function test_a_team_has_a_name()
    {
        $team = New Team(['name'=>'Ha']);

        $this->assertEquals('Ha',$team->name);

    }

    // 測試 隊伍可加入人員
    public function test_a_team_can_add_members()
    {
        // 建立一個 Team
        $team = factory(Team::class)->create();

        // 建立二個 User
        $user = factory(User::class)->create();
        $userTwo = factory(User::class)->create();

        // Team 加入 2個 user
        $team->add($user);
        $team->add($userTwo);
        
        $this->assertEquals(2, $team->count());
    }

    //　測試　隊伍一次加入兩位成員
    public function test_a_team_can_add_multiple_members()
    {
        $team = factory(Team::class)->create();

        $users = factory(User::class,2)->create();

        $team->add($users);

        $this->assertEquals(2, $team->count());

    }

    // 測試 隊伍最多能有幾個成員
    public function test_a_team_has_maximum_size()
    {
        $team = factory(Team::class)->create(['size'=>2]);

        $user = factory(User::class)->create();
        $userTwo = factory(User::class)->create();

        $team->add($user);
        $team->add($userTwo);

        $this->setExpectedException('Exception');

        $userThree = factory(User::class)->create();
        $team->add($userThree);
    }

    // 測試 在隊伍中移除成員
    public function test_a_team_can_remove_a_member()
    {
        $team = factory(Team::class)->create(['size' => 2]);

        $users = factory(User::class,2)->create();

        $team->add($users);
        
        $team->remove($users[0]);
        
        $this->assertEquals(1,$team->count());
    }

    // 測試 隊伍可以移出多名成員
    /** @test */
    public function a_team_can_remove_more_than_one_member_at_once()
    {
        $team = factory(Team::class)->create(['size' => 3]);
        $users = factory(User::class,3)->create();
        $team->add($users);

        // 成員取出兩位
        $team->remove($users->slice(0,2));
        
        $this->assertEquals(1,$team->count());
        
    }

    // 測試 隊伍移除全部成員
    public function test_a_team_can_remove_all_members_at_once()
    {

        $team = factory(Team::class)->create(['size' => 2]);

        $users = factory(User::class,2)->create();

        $team->add($users);

        $team->restart();

        $this->assertEquals(0,$team->count());
    }

}

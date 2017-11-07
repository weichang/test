<?php

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';
    protected $user;
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function signIn($user = null)
    {
        if(!$user){
            $user = factory(App\User::class)->create();
        }

        $this->user = $user;
        // actingAs 輔助方法提供了簡單的方式，讓指定的使用者認證為當前的使用者
        $this->actingAs($this->user);

        return $this;
    }
}

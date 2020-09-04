<?php

namespace Canvas\Tests\Models;

use Canvas\Http\Middleware\Session;
use Canvas\Models\Post;
use Canvas\Models\View;
use Canvas\Tests\TestCase;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ViewTest.
 *
 * @covers \Canvas\Models\View
 */
class ViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware([
            Authorize::class,
            Session::class,
            VerifyCsrfToken::class,
        ]);
    }

    /** @test */
    public function post_relationship()
    {
        $post = factory(Post::class)->create();

        $view = factory(View::class)->create([
            'post_id' => $post->id,
        ]);

        $post->views()->saveMany([$view]);

        $this->assertInstanceOf(BelongsTo::class, $view->post());
        $this->assertInstanceOf(Post::class, $view->post()->first());
    }
}
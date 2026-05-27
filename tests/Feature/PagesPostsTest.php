<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesPostsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_posts_page_handles_missing_posts(): void
    {
        $response = $this->get('/user_posts');

        $response->assertOk();
        $response->assertSee('No posts found.');
    }

    public function test_user_posts_page_shows_post_titles_and_content_for_a_user(): void
    {
        $user = User::factory()->create();

        $user->posts()->createMany([
            [
                'title' => 'My first post',
                'content' => 'First content',
            ],
            [
                'title' => 'My second post',
                'content' => 'Second content',
            ],
        ]);

        $response = $this->get('/user_posts');

        $response->assertOk();
        $response->assertSeeInOrder([
            'My first post',
            'First content',
            'My second post',
            'Second content',
        ]);
    }
}

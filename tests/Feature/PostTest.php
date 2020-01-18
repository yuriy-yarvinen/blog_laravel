<?php

namespace Tests\Feature;

use App\BlogPost;
use App\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
	// clear db for every test
	use RefreshDatabase;
    public function testNoBlogPostInDatabase()
    {
		$response = $this->get('/posts');
		
		$response->assertSeeText('No blog post here');
	}
	
	public function testSee1BlogPostWhenIs1WithNoComments()
	{
		// Arrange
		$user = $this->user();
		$this->actingAs($user);
		$post = $this->createPost($user->id);

		// Act
		$response = $this->get('/posts');

		// Assert
		$response->assertSeeText('New title');
		$response->assertSeeText('No comment yet');

		$this->assertDatabaseHas('blog_posts',[
			'title' => 'New title'
		]);
	}

	public function testSee1BlogPostWithComments()
	{
		// Arrange
		$user = $this->user();
		$this->actingAs($user);

		$post = $this->createPost($user->id);
		factory(Comment::class, 4)->create([
			'commentable_id' => $post->id,
			'commentable_type' => BlogPost::class,
			'user_id' => $user->id
		]);
		
		// Act
		$response = $this->get('/posts');
		$response->assertSeeText('4 comments');
	}

	public function testStorePostIsValid()
	{
		$user = $this->user();
		$this->actingAs($user);

		$params = [
			'title' => 'New title',
			'content' => 'New content',
			'json' => '{"new":"new"}',
			'user_id' => $user->id,
		];

		$this->post('/posts', $params)
			->assertStatus(302)
			->assertSessionHas('request_status');

		$this->assertEquals(session('request_status'),'Пост создан');

	}
	public function testStorePostIsFail()
	{
		$user = $this->user();
		$this->actingAs($user);

		$params = [
			'title' => 'Ne',
			'content' => 'tent',
			'json' => '{new":"new"}',
			'user_id' => $user->id,
		];

		$this->post('/posts', $params)
			->assertStatus(302)
			->assertSessionHas('errors');
		
		$messages = session('errors')->getMessages();

		$this->assertEquals($messages['title'][0],'Количество символов в поле Наименование должно быть не менее 5.');
		$this->assertEquals($messages['content'][0],'Количество символов в поле Контент должно быть не менее 10.');
		$this->assertEquals($messages['json'][0],'Поле json должно быть JSON строкой.');

	}

	public function testUpdatePost()
	{
		// Arrange
		$user = $this->user();
		$this->actingAs($user);

		$post = $this->createPost($user->id);
		$this->assertDatabaseHas('blog_posts', $post->toArray());

		$params = [
			'title' => 'New title kdkd',
			'content' => 'tent didnt change',
			'json' => '{"new":"new 2"}',
			'user_id' => $user->id
		];

		$this->put("/posts/{$post->id}", $params)
			->assertStatus(302)
			->assertSessionHas('request_status');
		
		$this->assertEquals(session('request_status'),'Пост обновлен');

		$this->assertDatabaseMissing('blog_posts', $post->toArray());
		$this->assertDatabaseHas('blog_posts', [
			'title' => 'New title kdkd'
		]);
	}

	public function testDeletePost()
	{
		$user = $this->user();
		$this->actingAs($user);
		$post = $this->createPost($user->id);
		
		// dd($user->id,$post->user_id);

		// dd($user, $post);

		$this->assertDatabaseHas('blog_posts', $post->toArray());

		$title = $post->title;
		
		$this->delete("/posts/{$post->id}")
			->assertStatus(302)
			->assertSessionHas('request_status');

		$this->assertEquals(session('request_status'),"Пост $title удален");

		// $this->assertDatabaseMissing('blog_posts', $post->toArray());
		$this->assertSoftDeleted('blog_posts', $post->toArray());
	}

	private function createPost($userId = null): BlogPost{
		// $post = new BlogPost();
		// $post->title = 'New title';
		// $post->content = 'New content';
		// $post->json = '{"new":"new"}';
		// $post->save();

		// return $post;

		return factory(BlogPost::class)->states('test_new_title')->create([
			'user_id' => $userId ?? $this->user()->id,
		]);
	}
}

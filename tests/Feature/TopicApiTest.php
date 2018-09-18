<?php

namespace Tests\Feature;

use App\Models\Topic;
use App\Models\User;
use Tests\TestCase;
use Tests\Traits\ActingJWTUser;

class TopicApiTest extends TestCase
{
    use ActingJWTUser;
    /**
    setUp 方法会在测试开始之前执行，我们先创建一个用户，测试会以该用户的身份进行测试。

    testStoreTopic 就是一个测试用户，测试发布话题。使用 $this->json 可以方便的模拟各种 HTTP 请求：
    第一个参数 —— 请求的方法，发布话题使用的是 POST 方法；
    第二个参数 —— 请求地址，请求 /api/topics；
    第三个参数 —— 请求参数，传入 category_id，body，title，这三个必填参数；
    第四个参数 —— 请求 Header，可以直接设置 header，也可以利用 withHeaders 方法达到同样的目的；
     **/

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function testStoreTopic()
    {
        $data = ['category_id' => 1, 'body' => 'test body', 'title' => 'test title'];

        $response = $this->JWTActingAs($this->user)
            ->json('POST', '/api/topics', $data);

        $assertData = [
            'category_id' => 1,
            'user_id'     => $this->user->id,
            'title'       => 'test title',
            'body'        => clean('test body', 'user_topic_body'),
        ];

        $response->assertStatus(201)
            ->assertJsonFragment($assertData);
    }

    public function testUpdateTopic()
    {
        $topic = $this->makeTopic();

        $editData = ['category_id' => 2, 'body' => 'edit body', 'title' => 'edit title'];

        $response = $this->JWTActingAs($this->user)
            ->json('PATCH', '/api/topics/' . $topic->id, $editData);

        $assertData = [
            'category_id' => 2,
            'user_id'     => $this->user->id,
            'title'       => 'edit title',
            'body'        => clean('edit body', 'user_topic_body'),
        ];

        $response->assertStatus(200)
            ->assertJsonFragment($assertData);
    }

    protected function makeTopic()
    {
        return factory(Topic::class)->create([
            'user_id'     => $this->user->id,
            'category_id' => 1,
        ]);
    }

    public function testShowTopic()
    {
        $topic    = $this->makeTopic();
        $response = $this->json('GET', '/api/topics/' . $topic->id);

        $assertData = [
            'category_id' => $topic->category_id,
            'user_id'     => $topic->user_id,
            'title'       => $topic->title,
            'body'        => $topic->body,
        ];

        $response->assertStatus(200)
            ->assertJsonFragment($assertData);
    }

    /**testShowTopic 先创建一个话题，然后访问 话题详情 接口，断言响应状态码为 200 以及响应数据与刚才创建的话题数据一致。

    testIndexTopic 直接访问 话题列表 接口，断言响应状态码为 200，断言响应数据结构中有 data 和 meta。**/
    public function testIndexTopic()
    {
        $response = $this->json('GET', '/api/topics');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'meta']);
    }

    public function testDeleteTopic()
    {
        $topic    = $this->makeTopic();
        $response = $this->JWTActingAs($this->user)
            ->json('DELETE', '/api/topics/' . $topic->id);
        $response->assertStatus(204);

        $response = $this->json('GET', '/api/topics/' . $topic->id);
        $response->assertStatus(404);
    }
}

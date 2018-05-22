<?php

use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        //所有用户id数组[1,2,3,4...]
        $user_ids = User::all()->pluck('id')->toArray();

        //所有分类id数组[1,2,3,4...]
        $category_ids = Category::all()->pluck('id')->toArray();

        //faker实例
        $faker = app(Faker\Generator::class);

        $topics = factory(Topic::class)
            ->times(100)
            ->make()
            ->each(function ($topic, $index)
                 use ($user_ids, $category_ids, $faker) {

                    //从用户id中随机取填充
                    $topic->user_id = $faker->randomElement($user_ids);

                    //分类同上
                    $topic->category_id = $faker->randomElement($category_ids);

                });

        Topic::insert($topics->toArray());
    }

}

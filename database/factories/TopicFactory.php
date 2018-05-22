<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    $sentence = $faker->sentence();

    /**随机一个月内的时间**/
    $updated_at = $faker->dateTimeThisMonth();
    /**创建时间要比更新时间早**/
    $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
        'title'      => $sentence, //sentence小段落生成
        'body'       => $faker->text(), //text()大段落生成
        'excerpt'    => $sentence,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});

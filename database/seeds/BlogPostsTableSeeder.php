<?php

use Illuminate\Database\Seeder;
use App\BlogPost;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        foreach(range(1,10) as $index){
        	BlogPost::create([
        		'user_id' => $faker->numberBetween($min = 1, $max = 5),
        		'post_date' => $faker->date($format = 'Y-m-d', $min = 'now'),
        		'post_title' => $faker->text($maxNbChars = 100),
        		'post_content' => $faker->text($maxNbChars = 600),
        		'post_status' => array_rand(['draft','published'])
        	]);
        }
    }
}

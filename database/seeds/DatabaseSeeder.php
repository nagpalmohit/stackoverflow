<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    private  $globalUser;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        /*Notes: */
        //we can create $user->question()->create() this will automatically put user_id of the current $user inside questions ka user_id

//        factory(\App\User::class, 5)
//            ->create()
//            //callback function for each user object
//            ->each(function ($user){
//                for ($i = 0 ; $i < rand(5,10);$i++){
//                    //Converting to array as create([]) takes array inside to make collection deta hai which then will be convert to toArray
//                    $user->questions()->create(factory(\App\Question::class)->make()->toArray());
//                }
//            });



        factory(\App\User::class , 5)
            ->create()
            ->each(function ($user){

                $user->questions()

                    ->saveMany(
                        factory(\App\Question::class,rand(2,5))->make()
                    )->each(function ($question){
                        $question->answers()
                            ->saveMany(
                                factory(\App\Answer::class,rand(2,7))->make()
                            );
                    });
            });

    }
}
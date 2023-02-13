<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tag;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    private $maxUsers = 10;
    private $maxTags = 50;
    private $maxTodos = 150;
    private $maxTagsInTodo = 4;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < $this->maxUsers + 1; $i++) {
            User::create(
                [
                    "name" => "Тестер №" . $i,
                    "email" => "tester" . $i . "@test.ru",
                    "password" => Hash::make('1234'),
                ]
            );
        }

        for ($i = 1; $i < $this->maxTags + 1; $i++) {
            Tag::create(
                [
                    "title" => "Тег №" . $i,
                ]
            );
        }

        for ($i = 1; $i < $this->maxTodos + 1; $i++) {

            $tags = Tag::whereIn('id', $this->_getRandomTags(rand(1, $this->maxTagsInTodo)))->get();
            $todo = new Todo();
            $todo->fill(
                [
                    "name" => "Задача №" . $i,
                    "description" => "Описание задача №" . $i,
                    "user_id" => rand(1, $this->maxUsers),
                    "status" => 'Не выполнена',
                ]
            );
            $todo->save();
            $todo->tags()->attach($tags);
        }

    }

    private function _getRandomTags($count){
        $range = [];
        foreach (range(0, $count - 1) as $i) {
            while(in_array($num = mt_rand(1, $this->maxTags), $range));
            $range[] = $num;
        }
        return $range;
    }
}

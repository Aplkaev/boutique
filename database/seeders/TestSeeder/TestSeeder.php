<?php

namespace Database\Seeders\TestSeeder;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ! make test user
        $user = User::factory()->create([
            'name' => 'Василий Георгиевич Шубутинский',
            'email' => 'v.shubutinsky82@gmail.com', // password: password
        ]);

        // ! create api_token for test user
        echo 'Creating api_token for test user...' . PHP_EOL;
        echo 'api_token: ' . $user->createToken('api_token')->plainTextToken . PHP_EOL;

        // parse the file of dataset
        $booksCollection = collect(json_decode(file_get_contents(database_path('seeders/TestSeeder/resources/dataset.json')), true));


        $authors = $booksCollection->map(function ($book) {
            return $book['authors'][0] ?? false;
        })->flatten()->unique();

        echo 'Creating authors...' . PHP_EOL;
        $authors->each(fn ($author) => Author::create(['name' => $author]));

        echo 'Creating books...' . PHP_EOL;
        $booksCollection->each(function ($book) {
            $bookModel = Book::create([
                'title' => $book['title'],
                'description' => str($book['shortDescription'] ?? $book['longDescription'] ?? 'No description')
                    ->trim(500),
                'author_id' => Author::where('name', $book['authors'][0])->first()->id,
                'publish_year' => (int) Carbon::parse($book['publishedDate']['$date'] ?? Carbon::now())
                    ->format('Y'),
            ]);

            if (isset($book['thumbnailUrl'])) {
                echo 'Making thumbnail...' . PHP_EOL;

                // ! download image to local storage only if it's not already exists
                try {
                    $bookModel
                        ->addMediaFromString(file_get_contents(database_path('seeders/TestSeeder/resources/images/' . basename($book['thumbnailUrl']))))
                        ->preservingOriginal()
                        ->toMediaCollection('cover');

                    echo 'Image ' . basename($book['thumbnailUrl']) . ' already exists' . PHP_EOL;

                } catch (\Exception $e) {
                    echo $e->getMessage() . PHP_EOL;
                    try {
                        $bookModel->addMediaFromUrl($book['thumbnailUrl'])->toMediaCollection('cover');

                        // ! save image to local storage
                        file_put_contents(database_path('seeders/TestSeeder/resources/images/' . basename($book['thumbnailUrl'])), file_get_contents($book['thumbnailUrl']));

                        echo 'Image ' . basename($book['thumbnailUrl']) . ' downloaded' . PHP_EOL;

                    } catch (\Exception $e) {
                        echo $e->getMessage() . PHP_EOL;
                        // ignore, it may be a broken image or empty image
                    }
                }
            }
        });
    }
}

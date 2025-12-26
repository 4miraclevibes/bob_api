<?php

namespace Database\Seeders;

use App\Models\DailyLearningQuestion;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DailyLearningQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DailyLearningQuestion::create([
            'question' => 'Apa perbedaan antara Promise.all() dan Promise.allSettled() di JavaScript?',
            'answer' => 'Promise.all() akan reject jika salah satu promise reject, sedangkan Promise.allSettled() akan menunggu semua promise selesai (baik resolve atau reject) dan mengembalikan array hasil semua promise.',
            'category' => 'best_practice',
            'difficulty' => 'intermediate',
            'tags' => ['javascript', 'async', 'promise', 'performance'],
            'keywords' => ['promise', 'async', 'javascript', 'all', 'allSettled'],
            'given_date' => Carbon::now()->subDays(5),
            'discussed_at' => Carbon::now()->subDays(5),
            'is_answered' => true,
            'source' => 'JavaScript Best Practices',
            'related_resources' => [
                ['title' => 'MDN Promise.all', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise/all'],
                ['title' => 'MDN Promise.allSettled', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise/allSettled'],
            ],
            'content_shared' => false,
        ]);

        DailyLearningQuestion::create([
            'question' => 'Apa itu Design Pattern Singleton dan kapan sebaiknya digunakan?',
            'answer' => 'Singleton adalah design pattern yang memastikan hanya ada satu instance dari sebuah class. Digunakan ketika kita perlu memastikan hanya ada satu instance yang mengelola resource tertentu seperti database connection atau logger.',
            'category' => 'design_pattern',
            'difficulty' => 'intermediate',
            'tags' => ['design_pattern', 'singleton', 'oop', 'architecture'],
            'keywords' => ['singleton', 'design pattern', 'oop', 'architecture'],
            'given_date' => Carbon::now()->subDays(3),
            'discussed_at' => Carbon::now()->subDays(3),
            'is_answered' => true,
            'source' => 'Design Patterns Book',
            'related_resources' => [
                ['title' => 'Singleton Pattern', 'url' => 'https://refactoring.guru/design-patterns/singleton'],
            ],
            'content_shared' => true,
        ]);

        DailyLearningQuestion::create([
            'question' => 'Bagaimana cara mengoptimalkan query database dengan index?',
            'answer' => 'Index dapat mempercepat query dengan membuat struktur data yang memungkinkan database menemukan data lebih cepat. Index sebaiknya dibuat pada kolom yang sering digunakan dalam WHERE clause, JOIN, atau ORDER BY.',
            'category' => 'database',
            'difficulty' => 'intermediate',
            'tags' => ['database', 'index', 'performance', 'sql'],
            'keywords' => ['database', 'index', 'performance', 'optimization'],
            'given_date' => Carbon::now()->subDays(1),
            'discussed_at' => null,
            'is_answered' => false,
            'source' => 'Database Optimization',
            'related_resources' => [
                ['title' => 'Database Indexing', 'url' => 'https://www.postgresql.org/docs/current/indexes.html'],
            ],
            'content_shared' => false,
        ]);

        DailyLearningQuestion::create([
            'question' => 'Apa itu RESTful API dan apa perbedaannya dengan GraphQL?',
            'answer' => null,
            'category' => 'architecture',
            'difficulty' => 'beginner',
            'tags' => ['api', 'rest', 'graphql', 'architecture'],
            'keywords' => ['rest', 'graphql', 'api', 'architecture'],
            'given_date' => null,
            'discussed_at' => null,
            'is_answered' => false,
            'source' => 'API Design',
            'related_resources' => null,
            'content_shared' => false,
        ]);

        DailyLearningQuestion::create([
            'question' => 'Bagaimana cara mengimplementasikan authentication dengan JWT?',
            'answer' => null,
            'category' => 'security',
            'difficulty' => 'advanced',
            'tags' => ['jwt', 'authentication', 'security', 'token'],
            'keywords' => ['jwt', 'authentication', 'security', 'token'],
            'given_date' => null,
            'discussed_at' => null,
            'is_answered' => false,
            'source' => 'Security Best Practices',
            'related_resources' => null,
            'content_shared' => false,
        ]);

        DailyLearningQuestion::create([
            'question' => 'Apa itu Big O Notation dan bagaimana cara menghitungnya?',
            'answer' => null,
            'category' => 'algorithm',
            'difficulty' => 'beginner',
            'tags' => ['algorithm', 'big o', 'complexity', 'performance'],
            'keywords' => ['big o', 'algorithm', 'complexity', 'performance'],
            'given_date' => null,
            'discussed_at' => null,
            'is_answered' => false,
            'source' => 'Algorithm Fundamentals',
            'related_resources' => null,
            'content_shared' => false,
        ]);

        DailyLearningQuestion::create([
            'question' => 'Apa perbedaan antara Array dan Linked List?',
            'answer' => null,
            'category' => 'data_structure',
            'difficulty' => 'beginner',
            'tags' => ['data structure', 'array', 'linked list', 'fundamentals'],
            'keywords' => ['array', 'linked list', 'data structure'],
            'given_date' => null,
            'discussed_at' => null,
            'is_answered' => false,
            'source' => 'Data Structures',
            'related_resources' => null,
            'content_shared' => false,
        ]);
    }
}

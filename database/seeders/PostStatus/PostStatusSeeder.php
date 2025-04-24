<?php

namespace Database\Seeders\PostStatus;

use App\Services\PostStatus\PostStatusService;
use Illuminate\Database\Seeder;

class PostStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $postStatus = resolve(PostStatusService::class);

        $data = $this->getPostStatusData();

        $postStatus->insert($data);
    }

    public function getPostStatusData(): array
    {
        return [
            [
                'code' => 'approved',
                'title' => 'تایید شده'
            ],
            [
                'code' => 'pending',
                'title' => 'در حال بررسی'
            ],
            [
                'code' => 'rejected',
                'title' => 'رد شده'
            ]
        ];
    }
}

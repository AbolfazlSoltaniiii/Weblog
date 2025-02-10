<?php

namespace App\Console\Commands;

use App\PostStatus;
use Illuminate\Console\Command;

class PostStatusCommand extends Command
{
    protected $signature = 'app:required-post-status';

    protected $description = 'Command for create required postStatus that needs';

    public function handle()
    {
        $postStatus = resolve(PostStatus::class);

        $data = $this->getPostStatusData();

        $result = $postStatus->insert($data);

        $this->info("post status created successfully");

        return $result;
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

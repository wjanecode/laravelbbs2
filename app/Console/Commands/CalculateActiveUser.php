<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CalculateActiveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabbs:calculate-active-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '计算活跃用户';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $user = new User();
        $user->calculateAndCacheActiveUsers();
        $this->info('活跃用户计算完毕');
    }
}

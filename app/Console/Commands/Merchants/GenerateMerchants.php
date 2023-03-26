<?php

namespace App\Console\Commands\Merchants;

use App\Models\Merchants\Merchant;
use Illuminate\Console\Command;

class GenerateMerchants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:merchants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates merchants using faker factory';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $count = intval($this->ask("How many merchants do you want to generate?"));

        Merchant::factory()
            ->count($count)
            ->create();

        echo "Merchants generated \n";
    }
}

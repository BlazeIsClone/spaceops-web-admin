<?php

namespace App\Console\Commands;

use App\Models\Country;
use Illuminate\Console\Command;
use App\Services\PermissionService;
use App\Services\UserRoleService;
use Illuminate\Support\Facades\Http;

class SyncCountries extends Command
{
    /**
     * Create a new command instance.
     */
    public function __construct(
        private PermissionService $permissionService,
        private UserRoleService $userRoleService,
    ) {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync country data from external API';

    /**
     * Country list API endpoint.
     *
     * @var string
     */
    protected $apiEndpoint = 'https://restcountries.com/v3.1/all';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->components->info("Fetching countries list from API");

        $response = Http::timeout(100)->get($this->apiEndpoint);

        if ($response->successful()) {
            $countries = $response->json();

            Country::truncate();

            foreach ($countries as $country) {
                Country::create([
                    'name' => $country['name']['common'],
                    'flag' => $country['flags']['png'],
                ]);
            }

            $this->components->info("Success! Countries have been updated");

            return Command::SUCCESS;
        }

        $this->components->error("Failure! Updating countries");

        return Command::FAILURE;
    }
}

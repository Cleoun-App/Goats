<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Goat;
use App\Models\MilkNote;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class AppInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'App initialization';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->warn('Starting Initialization...');

        $this->createDB();

        Artisan::call('key:generate');

        Artisan::call('storage:link');

        $this->warn('migrating databases...');

        Artisan::call('migrate:fresh');
        
        $this->warn('seeding default data...');

        Artisan::call('db:seed');

        $this->info('process completed succesfuly.');

        $user_count = rand(15, 25);

        $bar = $this->output->createProgressBar($user_count);

        $admin_user = User::all()->first();

        if ($admin_user instanceof User == false) {
            throw new \Exception('User Admin Tidak Tersedia!!');
        }

        $role_model = ['admin', 'user'];

        $this->warn("Generating $user_count users");

        $users = [];

        for ($i = 0; $i < $user_count; $i++) {

            if($i == 0) {
                $user =  User::factory()->create([
                    'username' => 'clouna16'
                ]);
            } else {
                $user =  User::factory()->create();
            }

            if ($user instanceof User) {

                $users[] = $user;

                $user_role = array_rand($role_model);

                $user->assignRole($role_model[$user_role]);

                $goat_gen = rand(10, 20);

                $milk_types = ['bulk', 'indi'];

                for($g = 0; $g < $goat_gen; $g++) {

                    $goat = Goat::factory()->create(['user_id' => $user->id]);

                    $milk_param = [
                        'user_id' => $user->id
                    ];

                    if($milk_types[rand(0,1) === 'indi']) {
                        $milk_param['goat_id'] = $goat->id;
                        $milk_param['type'] = 'individual';
                    }

                    MilkNote::factory(rand(4, 8))->create($milk_param);

                    Event::factory(rand(5,10))->create([
                        'user_id' => $user->id,
                        'scope' => 'individual',
                        'goat_id' => $goat->id,
                    ]);
                }


                // ....
            }

            
            MilkNote::factory(rand(1, 5))->create(['user_id' => $user->id]);

            Event::factory(rand(1, 5))->create(['user_id' => $user->id]);

            $bar->advance();

            // ...
        }


        $bar->finish();

        $this->info("");

        $this->info('Generated successfuly');

        $this->info('Initialization completed');

        return Command::SUCCESS;
    }

    public function createDB()
    {
        try{
            $new_db_name = env('DB_DATABASE');
            $new_mysql_username = env('DB_USERNAME');
            $new_mysql_password = env('DB_PASSWORD');

            
            $this->warn('Creating database');

            $conn = mysqli_connect(
                env('DB_HOST'), 
                env('DB_USERNAME'), 
                env('DB_PASSWORD')
            );
            if(!$conn ) {
                return false;
            }
            $sql = 'CREATE Database IF NOT EXISTS '.$new_db_name;
            $exec_query = mysqli_query( $conn, $sql);
            if(!$exec_query) {
                die('Could not create database: ' . mysqli_error($conn));
            }

            $this->info('Database successfuly created');

            return 'Database created successfully with name '.$new_db_name;

            
        }
        catch(\Exception $e){
            return false;
        }
    }
}

// 152-00-1879553-0

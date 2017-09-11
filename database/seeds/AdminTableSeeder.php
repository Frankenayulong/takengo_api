<?php

use Illuminate\Database\Seeder;
use App\User;
class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table_name = (new User)->getTable();

        DB::table($table_name)->delete();
        $column = $table_name.'_aid_seq';
    	DB::statement("ALTER SEQUENCE $column RESTART WITH 1");
        
        $kendrick = new User;
        $kendrick->first_name = 'Kendrick';
        $kendrick->last_name = 'Kesley';
        $kendrick->email = 's3642811@student.rmit.edu.au';
        $kendrick->password = bcrypt('kendricktakengo');
        $kendrick->remember_token = str_random(10);
        $kendrick->status = json_encode([
            'active' => true
        ]);
        $kendrick->last_ip = '::1';
        $kendrick->save();

        $veronica = new User;
        $veronica->first_name = 'Veronica';
        $veronica->last_name = 'Onggoro';
        $veronica->email = 's3642807@student.rmit.edu.au';
        $veronica->password = bcrypt('veronicatakengo');
        $veronica->remember_token = str_random(10);
        $veronica->status = json_encode([
            'active' => true
        ]);
        $veronica->last_ip = '::1';
        $veronica->save();

        $nadya = new User;
        $nadya->first_name = 'Nadya';
        $nadya->last_name = 'Safira';
        $nadya->email = 's3642868@student.rmit.edu.au';
        $nadya->password = bcrypt('nadyatakengo');
        $nadya->remember_token = str_random(10);
        $nadya->status = json_encode([
            'active' => true
        ]);
        $nadya->last_ip = '::1';
        $nadya->save();
    }
}

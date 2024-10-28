<?php

namespace Database\Seeders;

use App\Models\ZoomAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZoomAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        ZoomAccount::create([
            'account_name' => 'Zoom Admin 1',
            'client_key' => 'grl6L8IyRDGZ84ZZlHpzpA',
            'client_secret' => '9DzVYANHU9Hr0CNzh5UGKrqcn8iGHWCQ',
            'account_id' => '1Frw0ZsiSUqEG0zNWh4DUA',
        ]);

        ZoomAccount::create([
            'account_name' => 'Zoom Admin 2',
            'client_key' => 'G0rUNsRgQlm7CMpwtp82yg',
            'client_secret' => 'xuyKpwVzkUDbkXnzYSAOk898Zrou9htQ',
            'account_id' => '2iBG9sIVR6Kv45XfPaq6SA',
        ]);
    }
}

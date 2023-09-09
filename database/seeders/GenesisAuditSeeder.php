<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\BlockChainAudit;

class GenesisAuditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customDate = Carbon::create(2020, 9, 15); 
        
        BlockChainAudit::create([
          'auditable_type'=>"init_block",
          "event"=>"genesis_block",
          "nonce"=>0,
          "current_hash"=>"6c1be274af792f830ccdbcb303ac621feac595fbdf640fb309cc01b29eae5834",
          "previous_hash"=>"6c1be274af792f830ccdbcb303ac621feac595fbdf640fb309cc01b29eae5834",
          "created_at"=>$customDate
          ]);
          
    }
}

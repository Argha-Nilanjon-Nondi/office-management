<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\QueueBlockHash;
use App\Models\BlockChainAudit;

class CommandBlockHash extends Command
{
  /**
  * The name and signature of the console command.
  *
  * @var string
  */
  protected $signature = 'blockchain:block-hash';

  /**
  * The console command description.
  *
  * @var string
  */
  protected $description = 'Command description';


  public function make_hash() {

    $difficulty = 4; // difficulty level of hash

    // get a record which previous_hash,current_hash and nonce is not set yet
    // the record will be first old record
    $currentRecord = BlockChainAudit::whereNull('current_hash')
                                    ->whereNull('previous_hash')
                                    ->whereNull("nonce")
                                    ->select("id", "user_id", "user_type",
                                              "event", "auditable_id", "auditable_type",
                                              "old_values", "new_values", "ip_address", "url", "user_agent", "tags", 'created_at')
                                      ->orderBy('created_at', 'asc')
                                      ->first();
    
    if($currentRecord==null){
       $this->info("Every record is hashed \n");
       return 0;
    }

    // get the previous record of $currentRecord 
    $previousRecord = BlockChainAudit::where('created_at', '<', $currentRecord->created_at)
                                      ->select("current_hash")
                                      ->orderBy('created_at', 'desc')
                                      ->first();

     // generate nonce from 0 to N 
     // if the nonce is appropiate then $hashed_string will start with N number of "0"
     // here N is $difficulty
    for ($nonce = 0;;$nonce = $nonce+1) {
      
      // prepare data with nonce to crearte hash
      $data = json_encode([
        "data" => $currentRecord,
        "previous" => $previousRecord->current_hash,
        "nonce" => $nonce
      ]);

      // hash the data
      $hashed_string = hash('sha256', $data);

      // get first N character from $hashed_string according to $difficulty
      $first_four = substr($hashed_string, 0, $difficulty);

      // compare with hash
      if ($first_four === str_repeat("0", $difficulty)) {
        echo $hashed_string."\n";
        
        // entry the data to Audits model
        BlockChainAudit::where("id", $currentRecord->id)
        ->update([
          "previous_hash" => $previousRecord->current_hash,
          "current_hash" => $hashed_string,
          "nonce" => $nonce,
        ]);
        break;
      }
    }

}

  /**
  * Execute the console command.
  */
  public function handle() {
    $this->make_hash();
  }


}
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

  /**
  * Execute the console command.
  */
  public function handle() {
    
    $difficulty=4;
    
    $currentRecord = BlockChainAudit::whereNull('current_hash')
                              ->whereNull('previous_hash')
                              ->whereNull("nonce")
                              ->select("id", "user_id", "user_type",
                                        "event", "auditable_id", "auditable_type",
                                        "old_values", "new_values", "ip_address", "url", "user_agent", "tags", 
                                        \DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as created_at'))
                              ->orderBy('created_at', 'asc')
                              ->first();

    $previousRecord = BlockChainAudit::where('created_at', '<', $currentRecord->created_at)
                                    ->select("current_hash")
                                    ->orderBy('created_at', 'desc')
                                    ->first();

    echo $currentRecord->id;
    //echo $previousRecord;
    
    for($nonce=0;;$nonce=$nonce+1){
      
      $data=json_encode([
        "data"=>$currentRecord,
        "previous"=>$previousRecord->current_hash,
        "nonce"=>$nonce
        ]);
        
        echo $data;
        break;
      $hashed_string=hash('sha256', $data);
        /*
      $first_four=substr($hashed_string,0,$difficulty);
      
      if($first_four===str_repeat("0",$difficulty)){
        echo "hi";
        BlockChainAudit::where("id",$currentRecord->id)
        ->update([
          "previous_hash"=>$previousRecord->current_hash,
          "current_hash"=>$hashed_string,
          "nonce"=>$nonce,
          ]);
        break;
      }
      
      */
    
    }
    
    
  }
}
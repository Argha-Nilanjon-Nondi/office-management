<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockChainAudit extends Model
{
    use HasFactory;
    protected $table = 'audits';
    protected $fillable=["nonce","current_hash","previous_hash"];
}

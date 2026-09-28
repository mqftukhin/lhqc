<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QcRecord extends Model
{
    protected $guarded = []; // Mengizinkan semua field diisi massal

    public function masterPart(): BelongsTo
    {
        return $this->belongsTo(MasterPart::class, 'master_part_id');
    }

    public function masterOp(): BelongsTo
    {
        return $this->belongsTo(MasterOp::class, 'master_op_id');
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}

<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    public function columns()
    {
        return $this->hasMany(Column::class, 'board_id');
    }

    public function checkRights(int $userId)
    {
//        Board::
    }
}

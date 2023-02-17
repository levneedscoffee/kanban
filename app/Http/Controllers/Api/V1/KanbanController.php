<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\KanbanResources;
use App\Models\V1\Board;
use Illuminate\Http\Request;

class KanbanController extends Controller
{
    public function show($id)
    {
        $board = Board::find($id);
        if(is_null($board)) {
            return response()->json(['message' => 'Board not found.'], 404);
        }

        return new KanbanResources($board);
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BoardsRequest;
use App\Http\Resources\V1\BoardsResource;
use App\Models\V1\Board;
use Illuminate\Http\Request;

class BoardsController extends Controller
{
    public function store()
    {
        $allBoards = Board::paginate(15);

        return BoardsResource::collection($allBoards);
    }

    public function delete($id)
    {
        $board = Board::find($id);
        if(is_null($board)) {
            return response()->json(['message' => 'Board not found.'], 404);
        }

        $board->delete();

        return $this->store();
    }

    public function show($id)
    {
        $board = Board::find($id);

        if (is_null($board)) {
            return response()->json(['message' => 'Board not found.'], 404);
        }

        return new BoardsResource($board);
    }

    public function create(BoardsRequest $request)
    {
        $request = $request->validated();

        $board = new Board();
        $board->name = $request['name'];
        $board->user_id = 1;//добавить юзера
        $board->save();

        return new BoardsResource($board);
    }

    public function update(BoardsRequest $request, $id)
    {
        $validatedReq = $request->validated();

        $board = Board::find($id);
        if (is_null($board)) {
            return response()->json(['message' => 'Board not found.'], 404);
        }
        $board->name = $validatedReq['name'];
        $board->save();

        return new BoardsResource($board);
    }
}

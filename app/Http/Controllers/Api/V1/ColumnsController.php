<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ColumnsRequest;
use App\Http\Requests\V1\StoreColumnsRequest;
use App\Http\Requests\V1\UpdateColumnsRequest;
use App\Http\Resources\V1\ColumnsResource;
use App\Models\V1\Board;
use App\Models\V1\Column;

class ColumnsController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ColumnsRequest $request)
    {
        $request = $request->validated();

        $column = new Column();
        $column->name = $request['name'];
        $column->board_id = $request['board_id'];
        $column->turn = $request['turn'];
        $column->save();

        return new ColumnsResource($column);
    }


    public function store()
    {
        $allColumns = Column::all();

        return ColumnsResource::collection($allColumns);
    }


    public function show($id)
    {
        $column = Column::find($id);

        if (is_null($column)) {
            return response()->json(['message' => 'Column not found.'], 404);
        }

        return new ColumnsResource($column);
    }


    /**
     * @param ColumnsRequest $request
     * @param $id
     * @return ColumnsResource|\Illuminate\Http\JsonResponse
     */
    public function update(ColumnsRequest $request, $id)
    {
        $validatedReq = $request->validated();

        $column = Column::find($id);
        if (is_null($column)) {
            return response()->json(['message' => 'Column not found.'], 404);
        }

        $column->name = $validatedReq['name'];
        $column->turn = $validatedReq['turn'];
        $column->board_id = $validatedReq['board_id'];
        $column->save();

        return new ColumnsResource($column);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $column = Column::find($id);
        if(is_null($column)) {
            return response()->json(['message' => 'Column not found.'], 404);
        }
        $column->delete();

        return response()->json(['message' => 'Delete successful.']);;
    }
}

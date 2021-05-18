<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ItemController extends Controller
{

    /**
     * @return Builder[]|Collection |Item[]
     */
    public function index()
    {
        return Item::query()->orderByDesc('created_at')->get();
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'item' => 'required|array',
            'item.name' => 'required|string|max:191'
        ]);

        $name = $request->get('item')['name'];

        $item = Item::query()->create([
            'name' => $name
        ]);

        return response()->json(['data' => $item], 201);
    }


    public function show($id)
    {
        //
    }


    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {

        $item = Item::findOrFail($id);

        $request->validate([
            'item.name' => 'nullable|string|max:191',
            'item.completed' => 'nullable|boolean'
        ]);

        $data = $request->only(['name', 'completed']);
        if (!isset($data['completed'])){
            $data['completed'] = !$item->completed;
        }
        $data['completed_at'] = $data['completed'] ? Carbon::now() : null;

        $item->update($data);

        return response()->json(['data' => $item], 200);
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        if ($item->delete()) {
            return response()->json(['data' => null, 'status' => true, 'message' => 'Item Deleted'], 200);
        }
        return response()->json(['data' => null, 'status' => false, 'message' => 'Failed Deleting the Item'], 500);
    }
}

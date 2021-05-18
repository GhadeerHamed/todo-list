<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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


    public function store(Request $request)
    {
        $request->validate([
            'item' => 'required|array',
            'item.name' => 'required|string|max:191'
        ]);

        $name = $request->get('item')['name'];

        return Item::query()->create([
            'name' => $name
        ]);
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {

        $item = Item::findOrFail($id);

        $request->validate([
            'item.name' => 'nullable|string|max:191',
            'item.completed' => 'nullable|boolean'
        ]);

        $data = $request->only(['name', 'completed']);
        $data['completed_at'] = $item->completed_at ?? ($data['completed'] ? Carbon::now() : null);

        $item->update($data);

        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

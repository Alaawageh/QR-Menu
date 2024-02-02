<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Branch;
use App\Models\Category;
use App\Trait\ImageUploader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    use ImageUploader;

    public function index(Branch $branch , Category $category)
    {
        $items = Item::query()->Available()
        ->select('id','name','price')
        ->where('category_id',$category->id)->get();
        return ItemResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request , Branch $branch , Category $category)
    {
        $this->authorize('create' , [Item::class ,$branch , $category]);
        $item = $category->items()->create($request->safe()->except('image'));
        if ($request->hasFile('image')) {
            $this->uploadImage($request->file('image'),'items',$item);
        }
        return response()->json(['item' => $item ,'message' => 'Added Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch , Category $category ,Item $item)
    {
        return ItemResource::make($item);
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function update(UpdateItemRequest $request, Branch $branch , Category $category, Item $item)
    {
        $this->authorize('update',[Item::class,$branch,$category,$item]);
        $item->update($request->validated());
        return response()->json(['item' => $item ,'message' => 'Updated Successfully']); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch ,Category $category ,Item $item)
    {
        $this->authorize('delete',[Item::class,$branch,$category,$item]);
        Storage::disk('public')->delete($item->image?->url);
        $item->image()->delete();
        $item->delete();
        return response()->json(['message'=>'Deleted Successfully']);
    }
    public function editImage(ImageRequest $request, Branch $branch ,Category $category ,Item $item) {
        $this->authorize('updateImage',[Item::class,$branch,$category,$item]);
        $this->UpdateImage($request->file('image'),'items',$item);
        return response()->json(['message'=>'update image Successfully']); 
    }
    public function destroyImage(Branch $branch ,Category $category , Item $item) {
        $this->authorize('deleteImage',[Item::class,$branch,$category,$item]);
        $this->DeleteImage($item);
        return response()->json(['message'=>'Deleted Image Successfully']);
    }
    public function changeAvailable(Branch $branch , Category $category , Item $item) {
        $this->authorize('changeAvailable',[Item::class,$branch,$category,$item]);
        $item->update(['available' => ! $item->available]);
        return response()->json(['message'=>'updated Successfully']);
    }
    
}

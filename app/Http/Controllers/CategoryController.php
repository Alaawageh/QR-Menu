<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Trait\ImageUploader;
use App\Http\Requests\ImageRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    use ImageUploader;
    public function index(Branch $branch)
    {
        $category = Category::query()->available()->select('id','name')->where('branch_id',$branch->id)->get();
        return CategoryResource::collection($category);
    }
    public function store(StoreCategoryRequest $request , Branch $branch)
    {
       $category = $branch->categories()->create($request->safe()->except('image'));
       if ($request->hasFile('image')) {
        $this->uploadImage($request->file('image'),'category',$category);
       }
       return response()->json(['message'=>'Added Successfully','data'=>$category]);
    }
    public function show( Branch $branch,Category $category)
    {
        return CategoryResource::make($category);
    }
    public function update(UpdateCategoryRequest $request, Branch $branch, Category $category)
    {
        abort_if($branch->user_id != auth()->user()->id ,403,'unauthorized');
        $category->update($request->validated()); 
        return response()->json(['message'=>'Updated Successfully','data'=>$category]);
    }
    public function destroy(Branch $branch,Category $category)
    {
        abort_if($branch->user_id != auth()->user()->id ,403,'unauthorized');
        Storage::disk('public')->delete($category->image?->url);
        $category->image()->delete();
        $category->delete();
        return response()->json(['message'=>'Deleted Successfully']);
    }
    public function editImage(ImageRequest $request, Branch $branch ,Category $category ) {
        abort_if($branch->user_id != auth()->user()->id ,403,'unauthorized');
        $this->UpdateImage($request->file('image'),'category',$category);
        return response()->json(['message'=>'update image Successfully']); 
    }
    public function destroyImage(Branch $branch ,Category $category) {
        abort_if($branch->user_id != auth()->user()->id ,403,'unauthorized');
        $this->DeleteImage($category);
        return response()->json(['message'=>'Deleted Image Successfully']);
    }
    public function changeAvailable(Branch $branch , Category $category) {
        abort_if($branch->user_id != auth()->user()->id ,403,'unauthorized');
        $category->update(['available' => ! $category->available]);
        return response()->json(['message'=>'updated Successfully']);
    }
}

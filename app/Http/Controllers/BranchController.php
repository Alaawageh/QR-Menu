<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddBranchRequest;
use App\Http\Requests\EditBranchRequest;
use App\Http\Resources\BranchResource;
use App\Models\Branch;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BranchController extends Controller
{
    public function index() {
        $branches = Branch::select('id','name','tax')->where('user_id',auth()->user()->id)->get();
        return BranchResource::collection($branches);
    }
    public function show(Branch $branch) {
        return BranchResource::make($branch);
    }
    public function store(AddBranchRequest $request) {
        $branch = auth()->user()->branches()->create($request->validated());
        
        return response()->json(['data' => $branch ,'message' => 'The data has been saved successfully']);
 
    }
    public function update(EditBranchRequest $request, Branch $branch) {
        
        $branch->update($request->validated());
        return response()->json(['data' => $branch ,'message' => 'The data has been saved successfully']);
 
    }
    public function destroy(Branch $branch) {
        abort_if($branch->user_id != auth()->user()->id ,403 , 'unauthorized');
        $branch->delete();
        return response()->json(['message' => 'The data has been Deleted successfully']);

    }
 

}

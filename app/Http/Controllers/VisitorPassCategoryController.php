<?php

namespace App\Http\Controllers;

use App\Http\Requests\VisitorPassCategoryRequest;
use App\Http\Requests\VisitorPassCategoryUpdateRequest;
use App\VisitorPassCategory;
use Illuminate\Http\Request;
use App\VistorPassCategory;
use App\Traits\ResponseTrait;

class VisitorPassCategoryController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitorPassCategory = VisitorPassCategory::query()->orderBy('created_at, DESC');
        return $this->successResponse("List of Visitor Pass", 200, $visitorPassCategory);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VisitorPassCategoryRequest $request)
    {
        $visitorPassCategory = VistorPassCategory::query()->create($request->validated());
        return $this->successResponse("Visitor Pass Category Created Successfully", 200, $visitorPassCategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visitorPassCategory = VistorPassCategory::find($id);
        if (!$visitorPassCategory)
        {
            return $this->failedResponse('Visitor Pass Category Not Found', 400);
        }
        return $this->successResponse('Visitor Pass Category found', 200, $visitorPassCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VisitorPassCategoryUpdateRequest $request, $id)
    {
        $visitorPassCategory = VistorPassCategory::query()->find($id)
            ->update($request->validated());
        return $this->successResponse('Visitor Pass Successfully Updated', 200, $visitorPassCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $visitorPassCategory = VisitorPassCategory::query()->find($id);
        if(!$visitorPassCategory) return $this->failedResponse("Deletion Failed, Category does not exist");
        $deleteVisitorPassCategory = $visitorPassCategory->secureDelete();
        if ($deleteVisitorPassCategory == false) return $this->failedResponse("Deletion Failed, Category attached to pass");
        return $this->successResponse("Category successfully deleted");
    }
}

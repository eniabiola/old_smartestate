<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Street;

class StreetController extends Controller
{
    public function index($tenantid)
    {
         $housetype = DB::table('street')
        ->select('*')
        ->where("tenant", "=", $tenantid)
        ->orderBy('streetname', 'asc')
        ->get();
        return $housetype;
    }

    public function indexone($tenantid,$id)
    {
         $housetype = DB::table('street')
            ->select('*')
            ->where('id', '=', $id)
            ->get();
        return $housetype;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $housetype = Street::create($request->all());
        
        return response()->json($housetype, 201);
    }

    public function update(Request $request, $id)
    {
        $housetype = Street::findOrFail($id);
        $housetype->update($request->all());

        return response()->json($housetype, 200);
    }

    public function delete(Request $request, $id)
    {
        $housetype = Street::findOrFail($id);
        $housetype->delete();

        return response()->json(null, 204);
    }

}
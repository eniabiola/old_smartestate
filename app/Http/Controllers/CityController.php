<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\City;

class CityController extends Controller
{
    public function index($tenantid)
    {
         $city = DB::table('cities')
        ->select('cities.*','states.state AS state','states.id AS stateid')
->leftJoin('states', 'cities.state', '=', 'states.id')
        ->where("cities.tenant", "=", $tenantid)
        ->orWhere("cities.tenant", "=", "0")
        ->orderBy('cities.id', 'desc')
        ->get();
        return $city;
    }
public function indexmultiple($tenantid,$feild,$search)
    {
         $city = DB::table('cities')
        ->select('cities.*','states.state AS state','states.id AS stateid')
->leftJoin('states', 'cities.state', '=', 'states.id')
        ->where(function($query) use ($tenantid){
            $query->where("cities.tenant", $tenantid)
                ->orWhere("cities.tenant", "0");
        })
        ->where("cities.".$feild, "=", $search)
        ->orderBy('cities.id', 'desc')
        ->get();
        return $city;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $city = DB::table('cities')
        ->select('cities.*','states.state AS state','states.id AS stateid')
->leftJoin('states', 'cities.state', '=', 'states.id')
        ->where(function($query) use ($tenantid){
            $query->where("cities.tenant", $tenantid)
                ->orWhere("cities.tenant", "0");
        })
        ->where("cities.".$feild, "=", $search)
        ->where("cities.".$feild2, "=", $search2)
        ->orderBy('cities.id', 'desc')
        ->get();
        return $city;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM cities WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (city LIKE '%$search%' OR state LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM cities WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (city LIKE '%$search%' OR state LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $city = DB::table('cities')
            ->select('cities.*','states.state AS state_get')
->where('cities.id', '=', $id)
->leftJoin('states', 'cities.state', '=', 'states.id')
        ->get();
        return $city;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $city = City::create($request->all());
        
        return response()->json($city, 201);
    }

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $city->update($request->all());

        return response()->json($city, 200);
    }

    public function delete(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return response()->json(null, 204);
    }

}
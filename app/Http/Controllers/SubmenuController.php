<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Submenu;

class SubmenuController extends Controller
{
    public function index($tenantid)
    {
         $submenu = DB::table('submenus')
        ->select('submenus.*','mainmenus.mainmenu AS mainmenu','mainmenus.id AS mainmenuid')
->leftJoin('mainmenus', 'submenus.mainmenu', '=', 'mainmenus.id')
        ->where("submenus.tenant", "=", $tenantid)
        ->orWhere("submenus.tenant", "=", "0")
        ->orderBy('submenus.id', 'desc')
        ->get();
        return $submenu;
    }
public function indexmultiple($tenantid,$feild,$search)
    {
         $submenu = DB::table('submenus')
        ->select('submenus.*','mainmenus.mainmenu AS mainmenu','mainmenus.id AS mainmenuid')
->leftJoin('mainmenus', 'submenus.mainmenu', '=', 'mainmenus.id')
        ->where(function($query) use ($tenantid){
            $query->where("submenus.tenant", $tenantid)
                ->orWhere("submenus.tenant", "0");
        })
        ->where("submenus.".$feild, "=", $search)
        ->orderBy('submenus.id', 'desc')
        ->get();
        return $submenu;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $submenu = DB::table('submenus')
        ->select('submenus.*','mainmenus.mainmenu AS mainmenu','mainmenus.id AS mainmenuid')
->leftJoin('mainmenus', 'submenus.mainmenu', '=', 'mainmenus.id')
        ->where(function($query) use ($tenantid){
            $query->where("submenus.tenant", $tenantid)
                ->orWhere("submenus.tenant", "0");
        })
        ->where("submenus.".$feild, "=", $search)
        ->where("submenus.".$feild2, "=", $search2)
        ->orderBy('submenus.id', 'desc')
        ->get();
        return $submenu;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM submenus WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (mainmenu LIKE '%$search%' OR submenu LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM submenus WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (mainmenu LIKE '%$search%' OR submenu LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $submenu = DB::table('submenus')
            ->select('submenus.*','mainmenus.mainmenu AS mainmenu_get')
->where('submenus.id', '=', $id)
->leftJoin('mainmenus', 'submenus.mainmenu', '=', 'mainmenus.id')
        ->get();
        return $submenu;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $submenu = Submenu::create($request->all());
        
        return response()->json($submenu, 201);
    }

    public function update(Request $request, $id)
    {
        $submenu = Submenu::findOrFail($id);
        $submenu->update($request->all());

        return response()->json($submenu, 200);
    }

    public function delete(Request $request, $id)
    {
        $submenu = Submenu::findOrFail($id);
        $submenu->delete();

        return response()->json(null, 204);
    }

}
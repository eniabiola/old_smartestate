<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Mainmenu;

class MainmenuController extends Controller
{
    public function index($tenantid)
    {
        $submenu = Mainmenu::with('submenus')
        ->where("menuscope", "=", "Admin")
        ->orderBy("orderby")
        ->get();
        return $submenu;
    }
    public function indexresident($tenantid)
    {
        $submenu = Mainmenu::with('submenus')
        ->where("menuscope", "=", "Resident")
        ->orderBy("orderby","ASC")
        ->get();
        return $submenu;
    }
    public function indexsystem($tenantid)
    {
        $submenu = Mainmenu::with('submenus')
        ->where("menuscope", "=", "Super Admin")
        ->orderBy("orderby")
        ->get();
        return $submenu;
    }
    public function indexsecurity($tenantid)
    {
        $submenu = Mainmenu::with('submenus')
        ->where("menuscope", "=", "Security Post")
        ->orderBy("orderby")
        ->get();
        return $submenu;
    }
public function indexmultiple($tenantid,$feild,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM mainmenus WHERE (tenant = '$tenantid' OR tenant = '0') AND $feild = '$search' ORDER BY id DESC"),
        );
        return $results;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM mainmenus WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (mainmenu LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM mainmenus WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (mainmenu LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $mainmenu = DB::table('mainmenus')
            ->select('mainmenus.*')
->where('mainmenus.id', '=', $id)
        ->get();
        return $mainmenu;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $mainmenu = Mainmenu::create($request->all());
        
        return response()->json($mainmenu, 201);
    }

    public function update(Request $request, $id)
    {
        $mainmenu = Mainmenu::findOrFail($id);
        $mainmenu->update($request->all());

        return response()->json($mainmenu, 200);
    }

    public function delete(Request $request, $id)
    {
        $mainmenu = Mainmenu::findOrFail($id);
        $mainmenu->delete();

        return response()->json(null, 204);
    }

}
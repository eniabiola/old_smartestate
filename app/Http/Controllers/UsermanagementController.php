<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Usermanagement;

class UsermanagementController extends Controller
{
    public function index($tenantid)
    {
         $usermanagement = DB::table('usermanagements')
        ->select('*')
        ->where("usermanagements.tenant", "=", $tenantid)
        ->orderBy('usermanagements.id', 'desc')
        ->get();
        return $usermanagement;
    }
public function indexmultiple($tenantid,$feild,$search)
    {
         $usermanagement = DB::table('usermanagements')
        ->select('usermanagements.*','userroles.rolename AS rolename','userroles.id AS rolenameid')
->leftJoin('userroles', 'usermanagements.rolename', '=', 'userroles.id')
        ->where(function($query) use ($tenantid){
            $query->where("usermanagements.tenant", $tenantid)
                ->orWhere("usermanagements.tenant", "0");
        })
        ->where("usermanagements.".$feild, "=", $search)
        ->orderBy('usermanagements.id', 'desc')
        ->get();
        return $usermanagement;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $usermanagement = DB::table('usermanagements')
        ->select('usermanagements.*','userroles.rolename AS rolename','userroles.id AS rolenameid')
->leftJoin('userroles', 'usermanagements.rolename', '=', 'userroles.id')
        ->where(function($query) use ($tenantid){
            $query->where("usermanagements.tenant", $tenantid)
                ->orWhere("usermanagements.tenant", "0");
        })
        ->where("usermanagements.".$feild, "=", $search)
        ->where("usermanagements.".$feild2, "=", $search2)
        ->orderBy('usermanagements.id', 'desc')
        ->get();
        return $usermanagement;
    }


    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $results = DB::select(
            DB::raw("SELECT usermanagements.id,usermanagements.userfullname,usermanagements.tenant,usermanagements.rolename,subscribers.businessname FROM usermanagements,subscribers WHERE usermanagements.tenant = subscribers.id AND usermanagements.password = :pwd AND (usermanagements.email = :email OR usermanagements.phone = :phone OR usermanagements.username = :username)"),
            array(
                'pwd' => $password,
                'email' => $username,
                'phone' => $username,
                'username' => $username,
            )
        );
        return $results;
    }

    public function changepassword(Request $request)
    {
        $user = $request->input('user');
        $pword = $request->input('pword');
        $rolename = $request->input('rolename');
        if($rolename === "Resident"){
            $results = DB::table('residents')
            ->where('id', $user)
            ->update([
                'password' => $pword,
            ]);
        }else{
            $results = DB::table('usermanagements')
            ->where('id', $user)
            ->update([
                'password' => $pword,
            ]);
        }

        return $results;
    }

    public function loginresident(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $results = DB::select(
            DB::raw("SELECT residents.id,residents.meterno,CONCAT(residents.surname, ' ',residents.othername) as userfullname,
            residents.tenant,subscribers.businessname FROM residents,subscribers
            WHERE residents.tenant = subscribers.id AND residents.password = :pwd AND residents.regstatus = 'Active'
            AND (residents.email = :email OR residents.phone = :phone OR residents.residentid = :username)"),
            array(
                'pwd' => $password,
                'email' => $username,
                'phone' => $username,
                'username' => $username,
            )
        );
        return $results;
    }

    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM usermanagements WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (userfullname LIKE '%$search%' OR username LIKE '%$search%' OR phone LIKE '%$search%' OR rolename LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM usermanagements WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (userfullname LIKE '%$search%' OR username LIKE '%$search%' OR phone LIKE '%$search%' OR rolename LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
        $usermanagement = DB::table('usermanagements')
        ->select('*')
        ->where('id', '=', $id)
        ->get();
        return $usermanagement;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $usermanagement = Usermanagement::create($request->all());
        return response()->json($usermanagement, 201);
    }

    public function update(Request $request, $id)
    {
        $usermanagement = Usermanagement::findOrFail($id);
        $usermanagement->update($request->all());

        return response()->json($usermanagement, 200);
    }

    public function delete(Request $request, $id)
    {
        $usermanagement = Usermanagement::findOrFail($id);
        $usermanagement->delete();

        return response()->json(null, 204);
    }

}

<?php

namespace Modules\AgentLogin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Modules\AgentLogin\Entities\AgentLogin;
use Illuminate\Support\Facades\DB;
class AgentLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agent_logins = AgentLogin::where('status', 0)->get();

        return view('agentlogin::index', compact('agent_logins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('agentlogin::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:1000',
            'pan_number' => 'required|string|size:10|regex:/[A-Z]{5}[0-9]{4}[A-Z]{1}/',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->route('agentlogin.create')->withErrors($validator)->withInput();
        }

        AgentLogin::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'pan_number' => $request->pan_number,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        return redirect()->route('agentlogin.index')->with('success', 'Agent created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(Request $request, $id)
    {
        $perPage = 10;

        $agentId = $request->input('agent_id');

        $agent_logins = AgentLogin::where('status', 0)->where('delete', '0')->get();

        if ($agentId) {
            $todayBookingCount = DB::table('booking')->where('user_id', $agentId)->count();

            $userWithBookings = DB::table('users')
            ->leftJoin('booking', 'users.id', '=', 'booking.user_id')
            ->select('users.*', 'booking.*')->where('users.id', $agentId)
            ->where('booking.user_id', $agentId)
            ->paginate($perPage);

        } 
        else {
            $todayBookingCount = DB::table('booking')
            ->where('user_id', $id)
            ->count();

            $userWithBookings = DB::table('users')
            ->leftJoin('booking', 'users.id', '=', 'booking.user_id')
            ->select('users.*', 'booking.*')
            ->where('booking.user_id', $id)
            ->paginate($perPage);

        }

        return view('agentlogin::show', compact('todayBookingCount', 'userWithBookings', 'agent_logins'))->with('i', ($request->input('page', 1) - 1) * $perPage);
        // $agentId = $request->input('agent_id');

        // $agent_logins = AgentLogin::
        // where('status',0)->where('delete','0')
        // ->get();

        // $todayBookingCount = DB::table('booking')
        //     ->where('user_id', $id)
        //     ->count();

        // $userWithBookings = DB::table('users')
        //     ->leftJoin('booking', 'users.id', '=', 'booking.user_id')
        //     ->select('users.*', 'booking.*')
        //     ->where('users.id', $id)
        //     ->where('booking.user_id', $id)
        //     ->get();

        // $todayBookingCount = DB::table('booking')
        //     ->where('user_id', $id)
        //     ->whereDate('created_at', '=', $today)
        //     ->count();

        // $userWithBookings = DB::table('users')
        //     ->leftJoin('booking', 'users.id', '=', 'booking.user_id')
        //     ->select('users.*', 'booking.*')
        //     ->where('users.id', $id)
        //     ->whereDate('booking.created_at', '=', $today)
        //     ->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $agent = AgentLogin::findOrFail($id);
        return view('agentlogin::edit', compact('agent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:1000',
            'pan_number' => 'required|string|size:10|regex:/[A-Z]{5}[0-9]{4}[A-Z]{1}/',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string';
            $rules['password_confirmation'] = 'required|same:password';
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('agentlogin.edit', $id)->withErrors($validator)->withInput();
        }
        $agent = AgentLogin::findOrFail($id);
        $agent->name = $request->name;
        $agent->phone = $request->phone;
        $agent->email = $request->email;
        $agent->address = $request->address;
        $agent->pan_number = $request->pan_number;
        if ($request->filled('password')) {
            $agent->password = Hash::make($request->password);
        }
        $agent->status = $request->status;
        $agent->save();

        return redirect()->route('agentlogin.index')->with('success', 'Agent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $agent = AgentLogin::findOrFail($id);
        $agent->delete();
        return redirect()->route('agentlogin.index')->with('success', 'Agent deleted successfully.');
    }
}

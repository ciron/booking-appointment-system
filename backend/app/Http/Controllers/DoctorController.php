<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DoctorController extends Controller
{

    public function loginForm()
    {
        return view('login');
    }

    public function registerForm()
    {
        return view('Register');
    }

    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:doctors,email',
                'password' => 'required|string|min:6',  // Add password confirmation
                'specialization' => 'required|string|max:255',
            ]);
            DB::beginTransaction();
            $validatedData['password'] = Hash::make($validatedData['password']);
            $doctor = Doctor::create($validatedData);
            $token = $doctor->createToken('doctor-auth-token')->accessToken;
            DB::commit();
            return response()->json([
                'message' => 'Doctor registered successfully',
                'doctor' => $doctor,
                'token' => $token,
            ], 201); // 201 status code for resource creation
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred during registration.',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }

    public function login(Request $request)
    {

        if (Auth::guard('doctor')->check()) {

           return redirect()->route('dashboard');
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $doctor = Doctor::where('email', $credentials['email'])->first();



        if ($doctor && Hash::check($credentials['password'], $doctor->password)) {
            Auth::guard('doctor')->login($doctor);
            return redirect()->route('dashboard')->with('message', 'Login successful');
        }

        throw ValidationException::withMessages(['email' => 'Invalid credentials.']);
    }


    public function Dashboard()
    {
        return view('Dashboard');
    }

    public function ManageCalender()
    {
        $created_slot = DoctorSlot::where('doctor_id',Auth::guard('doctor')->user()->id)->get();
        $avaliable_slot =  AvailableSlot($created_slot->pluck('name')->toArray());

       $allSlots = All_slots();

        $availableMap = [];
        foreach ($created_slot as $slot) {
            $availableMap[$slot['date']][] = $slot['name'];
        }

        $events = [];
        foreach ($availableMap as $date => $slots) {
            $events = array_merge($events, generateEvents($date, $allSlots, $availableMap));
        }
        return view('Doctorcalender',compact('avaliable_slot','created_slot','events'));
    }

    public function AvailableForCreate(Request $request)
    {
        $created_slot = DoctorSlot::where('doctor_id',Auth::guard('doctor')->user()->id)->where('date',Carbon::parse($request->date)->format('Y-m-d'))->get();
        $avaliable_slot =  AvailableSlot($created_slot->pluck('name')->toArray());
        return view('Slotdropdown',compact('avaliable_slot'));
    }

    public function addNewSlot(Request $request)
    {
        $request->validate([
            'date'=>'required',
            'slot'=>'required'
        ]);
       if(!empty( $request->slot) && count($request->slot)){
           foreach( $request->slot as $row){
               DoctorSlot::create([
                   'date'=>Carbon::parse($request->date)->format('Y-m-d'),
                   'name'=>$row,
                   'doctor_id'=>Auth::guard('doctor')->user()->id,
               ]);
           }
       }
       return back();

    }

    public function DoctorList(){
        try {
            $doctorList = Doctor::whereHas('slots')->latest()->get();
            return successResponse($doctorList,'Doctor list','201');

        } catch (\Exception $e) {
            return failureResponse('An error occurred while get doctor list.',500,$e->getMessage());
        }
    }

    public function DoctorAvailableSlot($id){
        try {
            $doctorslotList = Doctor::with('slots')->find($id);
            return successResponse($doctorslotList,'Doctor Slot List','201');

        } catch (\Exception $e) {
            return failureResponse('An error occurred while get doctor list.',500,$e->getMessage());
        }
    }



    public function logout(Request $request)
    {
        Auth::guard('doctor')->logout();
        return redirect()->route('login');
    }
}

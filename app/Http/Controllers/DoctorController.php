<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return view('doctors', compact('doctors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fullName'       => 'required|string|max:255',
            'specialty'     => 'required|string|max:255',
            'profilePicture' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:20480',
        ]);

        if ($request->hasFile('profilePicture')) {
            $path = $request->file('profilePicture')
                            ->store('profile_pictures', 'public');
        } else {
            $path = 'none.png';
        }

        $doctor = Doctor::create([
            'full_name'       => $data['fullName'],
            'specialty'       => $data['specialty'],
            'profile_picture' => $path,
        ]);

        $html = view('partials.doctor-item', ['doctor' => $doctor])->render();

        return response()->json([
            'success' => true,
            'html'    => $html,
        ]);
    }

    public function destroy(Doctor $doctor)
    {
        if ($doctor->profile_picture !== 'none.png') {
            Storage::disk('public')->delete($doctor->profile_picture);
        }

        $doctor->delete();

        return response()->json(['success' => true]);
    }

    public function updateIcon(Request $request, Doctor $doctor)
    {
        $request->validate([
            'profilePicture' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:20480',
        ]);

        if ($doctor->profile_picture !== 'none.png') {
            Storage::disk('public')->delete($doctor->profile_picture);
        }

        $path = $request->file('profilePicture')
                        ->store('profile_pictures', 'public');

        $doctor->profile_picture = $path;
        $doctor->save();

        return response()->json([
            'success' => true,
            'newProfilePicture' => asset('storage/'.$path),
        ]);
    }

    public function all(): JsonResponse
    {
        $doctors = Doctor::all()->map(function (Doctor $doctor) {
            return [
                'id'              => $doctor->id,
                'name'            => $doctor->full_name,
                'specialty'       => $doctor->specialty,
                'profile_picture' => asset('storage/' . $doctor->profile_picture),
            ];
        });

        return response()->json($doctors);
    }
}

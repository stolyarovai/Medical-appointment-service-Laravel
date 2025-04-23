<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
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
        $request->validate([
            'fullName'       => 'required|string|max:255',
            'speciality'     => 'required|string|max:255',
            'profilePicture' => 'nullable|image|max:2048',
        ]);

        $path = $request->file('profilePicture')
                    ? $request->file('profilePicture')
                             ->store('profile_pictures', 'public')
                    : 'none.png';

        Doctor::create([
            'full_name'       => $request->fullName,
            'specialty'       => $request->speciality,
            'profile_picture' => $path,
        ]);

        return redirect()->route('doctors.index')
                         ->with('status', 'Врач добавлен.');
    }

    public function destroy(Doctor $doctor)
    {
        // Нужно будет убедиться, что фотография удаляется и из базы, и из хранилища
        if ($doctor->profile_picture !== 'none.png') {
            Storage::disk('public')->delete($doctor->profile_picture);
        }

        $doctor->delete();

        return redirect()->route('doctors.index')
                         ->with('status', 'Врач удалён.');
    }
}

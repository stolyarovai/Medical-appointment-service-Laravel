<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')
                    ->orderBy('full_name')
                    ->get();

        return view('users', [
            'users' => $users
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['success' => true]);
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $data = $request->validate([
            'field' => 'required|string|in:gender,birth_date',
            'value' => [
                'required',
                function ($attr, $value, $fail) use ($request) {
                    if ($request->field === 'birth_date') {
                        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) ||
                            strtotime($value) > time()) {
                            $fail('Неверный формат даты рождения.');
                        }
                    }
                    if ($request->field === 'gender' &&
                        ! in_array($value, ['male','female','undetermined'])) {
                        $fail('Недопустимое значение для пола.');
                    }
                },
            ],
        ]);

        $user->{$data['field']} = $data['value'];

        if ($user->save()) {
            return response()->json(['success' => true]);
        }

        return response()->json([
            'success' => false,
            'error'   => 'Не удалось обновить данные.'
        ], 500);
    }

    public function validateEmail(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        $exists = User::where('email', $data['email'])->exists();

        return response()->json([
            'exists' => $exists,
        ]);
    }
}

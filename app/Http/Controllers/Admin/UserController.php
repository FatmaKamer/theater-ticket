<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
//php artisan make:controller Admin/UserController --resource oluştururken resource yazdığım için index create store gibi fonksiyonlar kendisi geldi.
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class); //controllerda bu şekilde yazmak yerine bir authorize yapısı sayesinde index fonksiyonunun 
        //viewAny fonksiyonuyla bağlantılı olduğunu laravel anlayabilir
        $search = $request->get('search');
        
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%");
        })->paginate(10); //paginate sayfada arama sonucunun kaç tanesinin gösterileceğini belirler.

        return view('admin.users.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|confirmed',
        'role' => 'required|in:user,admin',
    ]);


    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role, // ⭐ Burada role geliyor, kontrol et
    ]);

    return redirect()->route('admin.users.index')
                     ->with('success', 'Kullanıcı başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Kullanıcı başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete',$user);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Kendi hesabınızı silemezsiniz.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Kullanıcı başarıyla silindi.');
    }
}

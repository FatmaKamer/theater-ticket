<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Routing\Attributes\Controllers\Authorize;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;

//#[Authorize(User::class)]
class UserController extends Controller {
//php artisan make:controller Admin/UserController --resource oluştururken resource yazdığım için index create store gibi fonksiyonlar kendisi geldi.
    public function __construct()
    {
        // User modeli için policy'yi otomatik eşleştir
        // Route parametresi 'user' ile eşleşmeli
        $this->authorizeResource(User::class, 'user');
    }

    public function index(Request $request)
    {
        //$this->authorize('viewAny', User::class); //controllerda bu şekilde yazmak yerine bir authorize yapısı sayesinde index fonksiyonunun 
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
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')
                     ->with('success', 'Kullanıcı başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
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
        
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Kendi hesabınızı silemezsiniz.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Kullanıcı başarıyla silindi.');
    }
}

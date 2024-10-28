<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AddUserModal extends Component
{
    use WithFileUploads;

    public $user_id;
    public $name;
    public $email;
    public $role;
    public $avatar;
    public $saved_avatar;
    public $password;
    public $phone;
    public $edit_mode = false;

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
        'role' => 'required|string',
        'password' => 'required|string',
        'avatar' => 'nullable|image|max:1024',
        'phone' => 'required|string',
    ];

    protected $listeners = [
        'delete_user' => 'deleteUser',
        'update_user' => 'updateUser',
        'update_user_status' => 'updateUserStatus',
        'new_user' => 'hydrate',
    ];

    public function render()
    {
        $roles = Role::all();

        $roles_description = [
            'super admin' => 'Best for super admins can do anything',
            'administrator' => 'Best for business owners and company administrators',
            'user' => 'Best for normal users can only access the orders page and update their profile and requirements',
        ];

        foreach ($roles as $i => $role) {
            $roles[$i]->description = $roles_description[$role->name] ?? '';
        }

        return view('livewire.user.add-user-modal', compact('roles'));
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            // إنشاء المستخدم مع البيانات الأساسية أولاً
            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->password = Hash::make($this->password);
            $user->status = 'غير فعال';
            $user->save();

            // معالجة رفع الصورة الرمزية بعد إنشاء المستخدم
            if ($this->avatar) {
                $image = $user->addMedia($this->avatar)->toMediaCollection('avatar');
                $user->avatar = $image->id . '/' . $image->file_name;
                $user->profile_photo_path = $image->id . '/' . $image->file_name;
                $user->save();
            }
            // تعيين الدور
            $user->assignRole($this->role);
            $this->dispatch('success', __('تم إنشاء مستخدم جديد'));
        });

        $this->reset();
    }

    public function deleteUser($id)
    {
        $userToDelete = User::findOrFail($id);

        // Check if the user to delete is a 'Super Admin'
        if ($userToDelete->roles()->first()->name === 'super admin') {
            // Count how many 'Super Admin' users are in the database
            $superAdminCount = User::whereHas('roles', function ($query) {
                $query->where('name', 'super admin');
            })->count();
            // Prevent deletion if there's only one 'Super Admin'
            if ($superAdminCount <= 1) {
                $this->dispatch('error', 'Cannot delete the last Super Admin');
                return;
            }

            // Prevent deletion of the current user
            if ($id == Auth::id()) {
                $this->dispatch('error', 'You cannot delete yourself as a Super Admin');
                return;
            }
        }

        // Proceed to delete the user record with the specified ID
        $userToDelete->delete();

        // Emit a success event with a message
        $this->dispatch('success', 'User successfully deleted');
    }


    public function updateUserStatus($id)
    {

        $user = User::find($id);

        $user->status = 'فعال';

        $user->save();

        $this->dispatch('success', 'User status successfully updated');
    }



    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->name = $this->name;
        $this->email = $this->email;
        $this->role = $this->role;
    }
}

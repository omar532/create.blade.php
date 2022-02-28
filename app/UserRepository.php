<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserRepository extends Model
{
    public function index($n, $role)
    {
        if($role != 'total')
        {
            return $this->model
                ->with('role')
                ->whereHas('role', function($q) use($role) {
                    $q->whereSlug($role);
                })
                ->oldest('seen')
                ->latest()
                ->paginate($n);
        }

        return $this->model
            ->with('role')
            ->oldest('seen')
            ->latest()
            ->paginate($n);
    }

    public function update($inputs, $user)
    {
        $user->confirmed = isset($inputs['confirmed']);

        $this->save($user, $inputs);
    }
    public function getAllSelect()
    {
        $select = $this->all()->lists('title', 'id');

        return compact('select');
    }
    public function store($inputs, $confirmation_code = null)
    {
        $user = new $this->model;

        $user->password = bcrypt($inputs['password']);

        if($confirmation_code) {
            $user->confirmation_code = $confirmation_code;
        } else {
            $user->confirmed = true;
        }

        $this->save($user, $inputs);

        return $user;
    }
    public function destroyUser(User $user)
    {
        $user->comments()->delete();

        $user->delete();
    }
}

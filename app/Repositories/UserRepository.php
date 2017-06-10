<?php namespace App\Repositories;

use App\Models\User;
use Davinciandalien\Repositories\Eloquent\Repository;
use Davinciandalien\Repository\Eloqument\CacheRepository;

class UserRepository extends CacheRepository
{
    protected function model()
    {
        // TODO: Implement model() method.
        return User::class;
    }

    public function search($request)
    {
        // TODO: Implement search() method.
        $users = User::with('roles');

        $kw = $request->input('kw');

        if(! empty($kw)){
            $users = $users->where(function ($query) use ($kw){
                $query->where('name','like','%'.$kw.'%')->orWhere('email','like','%'.$kw.'%');
            });
        }

        return $users;
    }
}
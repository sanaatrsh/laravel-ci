<?php

namespace App\Services;

use App\Data\UserData;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserService
{
    /**
     * Validate user data.
     * Store to DB if there are no errors.
     *
     * @throws Throwable
     */
    public function store(UserData $data): User
    {
        return DB::transaction(static function () use ($data) {
            $user = User::create($data->onlyModelAttributes());

            return $user;
        });
    }

    /**
     * Update user data
     * Store to DB if there are no errors.
     *
     * @throws Throwable
     */
    public function update(UserData $data, User $user): User
    {
        return DB::transaction(static function () use ($data, $user) {
            tap($user)->update($data->onlyModelAttributes());

            return $user;
        });
    }
}

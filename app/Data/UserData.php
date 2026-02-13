<?php

declare(strict_types=1);

namespace App\Data;

use Mrmarchone\LaravelAutoCrud\Traits\HasModelAttributes;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Date;
use Carbon\Carbon;
use App\Models\User;


class UserData extends Data
{
    use HasModelAttributes;

/** @var class-string<User> */
    protected static string $model = User::class;

    public function __construct(
        public ?string $name,
        public ?string $email,
        #[Date]
        public ?Carbon $emailVerifiedAt
    ) {}
}

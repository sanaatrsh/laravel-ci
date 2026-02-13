<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\User;
use Carbon\Carbon;
use Mrmarchone\LaravelAutoCrud\Traits\HasModelAttributes;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Data;

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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BadExampleController extends Controller
{
    public function index(Request $request)
    {

        // ❌ Pint: تنسيق سيء + مسافات + Style مخالف

        $name = $request->input('name');

        // ❌ PHPStan: ممكن يرجع null لكن نعامله string مباشرة
        $upperName = strtoupper($name);

        // ❌ Rector: array() قديم بدل []
        $data = [
            'name' => $upperName,
            'time' => time(),
        ];

        // ❌ PHPStan: return type غير محدد
        return response()->json($data);
    }

    public function getUser($id)
    {

        // ❌ PHPStan: $id يجب أن يكون int وليس string
        $user = DB::table('users')->where('id', $id)->first();

        // ❌ PHPStan: ممكن يكون null ثم نستخدم property
        return $user->email;
    }

    public function calculateTotal($numbers)
    {

        // ❌ PHPStan: لا يوجد Type Hint
        $total = 0;

        foreach ($numbers as $n) {

            // ❌ PHPStan: قد يكون $n string
            $total += $n;
        }

        // ❌ Rector: يمكن استخدام array_sum
        return $total;
    }

    public function unusedCode()
    {

        // ❌ Rector: متغير غير مستخدم
        $x = 10;

        // ❌ Pint: تنسيق سيء
        if (true) {
            echo 'hello';
        }
    }
}

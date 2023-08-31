<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class PhoneRule implements ValidationRule
{
    
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!Str::startsWith($value,['07','964']))
            $fail('The :attribute must be Start with 07 or 964');

        if (strlen($value) < 11) 
            $fail('The :attribute must be greater then 11');

        if (strlen($value) > 13) 
            $fail('The :attribute must be Lower then 13');

    }
    
   
}

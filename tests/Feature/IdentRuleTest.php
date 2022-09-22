<?php

namespace Tests\Feature;

use App\Rules\IdentRule;
use Illuminate\Auth\Events\Validated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\CreatesApplication;
use Tests\TestCase;

class IdentRuleTest extends TestCase
{
    use CreatesApplication;

    public function test識別子ルールのテスト()
    {
        $tests = [
            '-' => true,
            '-' => true,
            '@' => true,
            '.' => true,
            '0' => true,
            'a' => true,
            'z' => true,
            'A' => true,
            'Z' => true,
            '&' => false,
            '%' => false,
            '(' => false,
            ')' => false,
            '+' => false,
            '=' => false,
            'a a' => false,
        ];

        foreach($tests as $key => $value){
            try{
                Validator::make(['test' => $key],[
                    'test' => [ new IdentRule()],
                ])->validate();
                $this->assertTrue($value);
            }catch(ValidationException $e){
                $this->assertFalse($value);
            }
        }
    }
}

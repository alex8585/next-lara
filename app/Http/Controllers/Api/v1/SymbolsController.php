<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Symbol;
use Illuminate\Http\Request;

class SymbolsController extends Controller
{
    public function index()
    {
        $symbols = Symbol::select(['id', 'base'])->get()->map(function ($tag) {
            return [
                'id' => $tag->id,
                'name' => $tag->base,
            ];
        });

        return $symbols;
    }
}

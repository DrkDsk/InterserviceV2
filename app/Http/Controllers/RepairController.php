<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class RepairController extends Controller
{
    public function index()
    {
        return Inertia::render('Repair/RepairIndex');
    }
}

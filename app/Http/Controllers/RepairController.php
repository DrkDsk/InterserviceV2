<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class RepairController extends Controller
{
    public function index()
    {
        return Inertia::render('Repair/RepairIndex');
    }

    public function create()
    {
        return Inertia::render('Repair/RepairCreate');
    }

    public function store()
    {

    }
}

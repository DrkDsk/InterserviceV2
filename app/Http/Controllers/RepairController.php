<?php

namespace App\Http\Controllers;

use App\useCases\DeviceCategories\GetDeviceCategoriesUseCase;
use Inertia\Inertia;

class RepairController extends Controller
{
    public function index()
    {
        return Inertia::render('Repair/RepairIndex');
    }

    public function create(GetDeviceCategoriesUseCase $getDeviceCategoriesUseCase)
    {
        $deviceCategories = $getDeviceCategoriesUseCase->execute();

        return Inertia::render('Repair/RepairCreate', [
            'deviceCategories' => $deviceCategories
        ]);
    }

    public function store()
    {

    }
}

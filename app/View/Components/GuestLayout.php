<?php

namespace App\View\Components;

use App\Models\Shop;
use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $setting = Shop::first();
        return view('layouts.guest-layout', compact('setting'));
    }
}

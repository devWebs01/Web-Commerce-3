<?php

use function Laravel\Folio\name;
use Dipantry\Rajaongkir\Models\ROProvince;
use Dipantry\Rajaongkir\Models\ROCity;
use function Livewire\Volt\{state, computed, rules};

name('account.auth');

state(['province_id'])->url();

state([
    'name' => fn() => $this->getShop->name ?? '',
    'province_id' => fn() => $this->getShop->province_id ?? '',
    'city_id' => fn() => $this->getShop->city_id ?? '',
    'details' => fn() => $this->getShop->details ?? '',
    'provinces' => fn() => ROProvince::all(),
]);

$cities = computed(function () {
    return ROCity::where('province_id', $this->province_id)->get();
});

rules([
    'name' => 'required|min:5',
    'province_id' => 'required|exists:rajaongkir_provinces,id',
    'city_id' => 'required|exists:rajaongkir_cities,id',
    'details' => 'required|min:20',
]);

$submit = function () {
    $validate = $this->validate();
    if ($this->getShop) {
        $updateShop = Shop::first();
        $updateShop->update($validate);
    } elseif (!$this->getShop) {
        Shop::create($validate);
    }
    $this->dispatch('address-update');
};

?>
<x-admin-layout>
    <x-slot name="title">Akun Profile</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('account.auth') }}">Akun Profile</a></li>
    </x-slot>

    @volt
        <div>
            <div class="card overflow-hidden">
                <div class="card-header p-0">
                    <img src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/images/backgrounds/profilebg.jpg"
                        alt="matdash-img" class="img-fluid">
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">

                            <button class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-profile" type="button" role="tab"
                                aria-controls="v-pills-profile" aria-selected="true">Akun Profile</button>

                            <button class="nav-link" id="v-pills-password-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-password" type="button" role="tab"
                                aria-controls="v-pills-password" aria-selected="true">Ganti Password</button>


                        </div>
                        <div class="tab-content" id="v-pills-tabContent">

                            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                                aria-labelledby="v-pills-profile-tab" tabindex="0">
                                @include('pages.admin.account.profile')

                            </div>

                            <div class="tab-pane fade" id="v-pills-password" role="tabpanel"
                                aria-labelledby="v-pills-password-tab" tabindex="0">
                                @include('pages.admin.account.password')

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-admin-layout>

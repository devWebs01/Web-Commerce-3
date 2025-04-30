<?php

use Dipantry\Rajaongkir\Models\ROProvince;
use Dipantry\Rajaongkir\Models\ROCity;
use App\Models\Shop;
use function Livewire\Volt\{state, computed, rules, uses};
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);

state(['province_id'])->url();

$getShop = computed(function () {
    return Shop::first();
});

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

$save = function () {
    $validate = $this->validate();
    if ($this->getShop) {
        $updateShop = Shop::first();
        $updateShop->update($validate);
        $this->dispatch('profile-shop');
        $this->alert('success', 'Data toko berhasil di perbaharui!', [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);
    } elseif (!$this->getShop) {
        Shop::create($validate);
    }
};

?>
@volt
    <div>
        <div class="alert alert-primary" role="alert">
            <strong>Profile Toko</strong>
            <p>bagian di mana informasi penting tentang toko Anda disimpan. Ini mencakup nama toko, alamat lengkap beserta
                provinsi dan kota, yang memengaruhi pengiriman barang. Pastikan informasi ini diperbarui dengan benar untuk
                memastikan kelancaran proses pengiriman.</p>
        </div>

        <form wire:submit="save">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Toko</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" id="name"
                    aria-describedby="nameId" placeholder="Enter name store" />
                @error('name')
                    <small id="nameId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="province_id" class="form-label">Provinsi</label>
                <select class="form-select @error('province_id') is-invalid @enderror" wire:model.live="province_id"
                    id="province_id">
                    <option>Pilih Provinsi</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                    @endforeach
                </select>
                @error('province_id')
                    <small id="provinceId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="city_id" class="form-label">Kota</label>
                <select class="form-select @error('city_id') is-invalid @enderror" wire:model="city_id" id="city_id">
                    <option>Pilih Kota</option>
                    @foreach ($this->cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('city_id')
                    <small id="cityId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="details" class="form-label">Alamat Lengkap</label>
                <textarea class="form-control @error('details') is-invalid @enderror" wire:model="details" id="details"
                    aria-describedby="detailsId" placeholder="Enter Alamat Lengkap" rows="8"></textarea>

                @error('details')
                    <small id="detailsId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="row mb-3">
                <div class="col-md">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
                <div class="col-md align-self-center text-end">
                    <span wire:loading class="spinner-border spinner-border-sm"></span>
                </div>
            </div>
        </form>
    </div>
@endvolt

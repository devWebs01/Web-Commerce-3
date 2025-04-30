<?php

use function Livewire\Volt\{computed, state, on};
use App\Models\Shop;
use App\Models\Order;

state([
    'orders' => fn() => Order::whereStatus('PENDING')->count() ?? null,
    'profileShop' => fn() => Shop::first(),
]);

on([
    'orders-alert' => function () {
        $this->orders = Order::whereStatus('PENDING')->count();
    },
    'profile-shop' => function () {
        $this->profileShop = Shop::first();
    },
]);

?>


<div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="#" class="text-nowrap logo-img">
            <h4 style="font-weight: 900" class="ms-lg-2 text-primary">
                {{ $this->profileShop->name }}
            </h4>
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
        </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false"
                    {{ request()->routeIs('dashboard') }}>
                    <iconify-icon icon="solar:home-2-bold"></iconify-icon>
                    <span class="hide-menu">Beranda
                    </span>
                </a>
            </li>
            <li>
                <span class="sidebar-divider lg"></span>
            </li>

            @if (auth()->user()->role == 'superadmin')


                <li class="nav-small-cap">
                    <iconify-icon icon="solar:shield-user-outline" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Pengguna</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('users.index') }}" aria-expanded="false"
                        {{ request()->routeIs('users.index') }}>
                        <iconify-icon icon="solar:shield-user-outline"></iconify-icon>
                        <span class="hide-menu">Admin</span>
                    </a>
                    <a class="sidebar-link" href="{{ route('customers') }}" aria-expanded="false"
                        {{ request()->routeIs('customers') }}>
                        <iconify-icon icon="solar:user-circle-bold"></iconify-icon>
                        <span class="hide-menu">Pelanggan</span>
                    </a>
                </li>
                <li>
                    <span class="sidebar-divider lg"></span>
                </li>

                <li class="nav-small-cap">
                    <iconify-icon icon="solar:shop-2-bold" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Toko</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('categories-product') }}" aria-expanded="false"
                        {{ request()->routeIs('categories-product') }}>
                        <iconify-icon icon="solar:widget-add-line-duotone"></iconify-icon>
                        <span class="hide-menu">Kategori Produk</span>
                    </a>
                    <a class="sidebar-link" href="{{ route('products.index') }}" aria-expanded="false"
                        {{ request()->routeIs('products.index') }}>
                        <iconify-icon icon="solar:bacteria-bold"></iconify-icon>
                        <span class="hide-menu">Produk Toko</span>
                    </a>
                    <a class="sidebar-link" href="{{ route('setting-store') }}" aria-expanded="false"
                        {{ request()->routeIs('setting-store') }}>
                        <iconify-icon icon="solar:shop-2-bold"></iconify-icon>
                        <span class="hide-menu">Pengaturan</span>
                    </a>
                </li>
                <li>
                    <span class="sidebar-divider lg"></span>
                </li>

                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Kelola Transaksi</span>
                </li>

                <li class="sidebar-item position-relative">
                    <a class="sidebar-link" href="{{ route('transactions.index') }}" aria-expanded="false"
                        {{ request()->routeIs('transactions.index') }}>
                        <iconify-icon icon="solar:round-transfer-diagonal-bold"></iconify-icon>
                        <span class="hide-menu">Transaksi</span>
                    </a>
                    @if ($orders > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $orders }}
                        </span>
                    @endif
                </li>
                <li>
                    <span class="sidebar-divider lg"></span>
                </li>

                <li class="nav-small-cap">
                    <iconify-icon icon="solar:add-folder-bold" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Kelola Laporan</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('report.categories-product') }}" aria-expanded="false"
                        {{ request()->routeIs('report.categories-product') }}>
                        <iconify-icon icon="solar:add-folder-bold"></iconify-icon>
                        <span class="hide-menu">Data Kategori</span>
                    </a>
                    <a class="sidebar-link" href="{{ route('report.products') }}" aria-expanded="false"
                        {{ request()->routeIs('report.products') }}>
                        <iconify-icon icon="solar:add-folder-bold-duotone"></iconify-icon>
                        <span class="hide-menu">Data Produk</span>
                    </a>
                    <a class="sidebar-link" href="{{ route('report.customers') }}" aria-expanded="false"
                        {{ request()->routeIs('report.customers') }}>
                        <iconify-icon icon="solar:add-folder-broken"></iconify-icon>
                        <span class="hide-menu">Data Pelanggan</span>
                    </a>
                    <a class="sidebar-link" href="{{ route('report.transactions') }}" aria-expanded="false"
                        {{ request()->routeIs('report.transactions') }}>
                        <iconify-icon icon="solar:accumulator-line-duotone"></iconify-icon>
                        <span class="hide-menu">Data Transaksi</span>
                    </a>
                </li>
                <li>
                    <span class="sidebar-divider lg"></span>
                </li>
            @elseif(auth()->user()->role == 'admin')
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:shield-user-outline" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Menu Karyawan</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('customers') }}" aria-expanded="false"
                        {{ request()->routeIs('customers') }}>
                        <iconify-icon icon="solar:user-circle-bold"></iconify-icon>
                        <span class="hide-menu">Pelanggan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('products.index') }}" aria-expanded="false"
                        {{ request()->routeIs('products.index') }}>
                        <iconify-icon icon="solar:bacteria-bold"></iconify-icon>
                        <span class="hide-menu">Produk Toko</span>
                    </a>
                    <a class="sidebar-link" href="{{ route('transactions.index') }}" aria-expanded="false"
                        {{ request()->routeIs('transactions.index') }}>
                        <iconify-icon icon="solar:round-transfer-diagonal-bold"></iconify-icon>
                        <span class="hide-menu">Transaksi</span>
                    </a>
                    @if ($orders > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $orders }}
                        </span>
                    @endif
                </li>

                <li>
                    <span class="sidebar-divider lg"></span>
                </li>

                <li class="nav-small-cap">
                    <iconify-icon icon="solar:add-folder-bold" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Kelola Laporan</span>
                </li>

                <li class="sidebar-item position-relative">
                    <a class="sidebar-link" href="{{ route('report.transactions') }}" aria-expanded="false"
                        {{ request()->routeIs('report.transactions') }}>
                        <iconify-icon icon="solar:accumulator-line-duotone"></iconify-icon>
                        <span class="hide-menu">Data Transaksi</span>
                    </a>
                </li>
            @endif
    </nav>
    <!-- End Sidebar navigation -->
</div>

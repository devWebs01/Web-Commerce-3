<?php

use function Livewire\Volt\{computed, state, on};
use App\Models\Shop;
use App\Models\Order;

state([
    "orders" => fn() => Order::whereStatus("PENDING")->count(),
    "profileShop" => fn() => Shop::first(),
]);

on([
    "orders-alert" => fn() => ($this->orders = Order::whereStatus("PENDING")->count()),
    "profile-shop" => fn() => ($this->profileShop = Shop::first()),
]);
?>

@volt
    <div>
        <!-- Brand Logo -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="#" class="text-nowrap logo-img">
                <h4 class="ms-lg-2 text-primary fw-bold">
                    {{ $this->profileShop?->name ?? "Nama Toko" }}
                </h4>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="fas fa-times fs-8"></i>
            </div>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="sidebar-nav scroll-sidebar">
            <ul id="sidebarnav">
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs("dashboard") ? "active" : "" }}"
                        href="{{ route("dashboard") }}">
                        <i class="fas fa-home me-2"></i>
                        <span class="hide-menu">Beranda</span>
                    </a>
                </li>

                <li><span class="sidebar-divider lg"></span></li>

                @if (auth()->user()->role === "superadmin")
                    <!-- Section: Pengguna -->
                    <li class="nav-small-cap">
                        <i class="fas fa-user-shield nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Pengguna</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs("users.index") ? "active" : "" }}"
                            href="{{ route("users.index") }}">
                            <i class="fas fa-user-shield me-2"></i>
                            <span class="hide-menu">Admin</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs("customers") ? "active" : "" }}"
                            href="{{ route("customers") }}">
                            <i class="fas fa-users me-2"></i>
                            <span class="hide-menu">Pelanggan</span>
                        </a>
                    </li>

                    <li><span class="sidebar-divider lg"></span></li>

                    <!-- Section: Toko -->
                    <li class="nav-small-cap">
                        <i class="fas fa-store nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Toko</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs("categories.index") ? "active" : "" }}"
                            href="{{ route("categories.index") }}">
                            <i class="fas fa-tags me-2"></i>
                            <span class="hide-menu">Kategori Produk</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs("products.index") ? "active" : "" }}"
                            href="{{ route("products.index") }}">
                            <i class="fas fa-boxes me-2"></i>
                            <span class="hide-menu">Produk Toko</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs("setting.store") ? "active" : "" }}"
                            href="{{ route("setting.store") }}">
                            <i class="fas fa-cog me-2"></i>
                            <span class="hide-menu">Pengaturan</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs("cashier.index") ? "active" : "" }}"
                            href="{{ route("cashier.index") }}">
                            <i class="fas fa-cash-register me-2"></i>
                            <span class="hide-menu">Kasir</span>
                        </a>
                    </li>

                    <li><span class="sidebar-divider lg"></span></li>

                    <!-- Section: Transaksi -->
                    <li class="nav-small-cap">
                        <i class="fas fa-random nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Kelola Transaksi</span>
                    </li>
                    <li class="sidebar-item position-relative">
                        <a class="sidebar-link {{ request()->routeIs("transactions.index") ? "active" : "" }}"
                            href="{{ route("transactions.index") }}">
                            <i class="fas fa-exchange-alt me-2"></i>
                            <span class="hide-menu">Transaksi</span>
                        </a>
                        @if ($orders > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $orders }}
                            </span>
                        @endif
                    </li>

                    <li><span class="sidebar-divider lg"></span></li>

                    <!-- Section: Laporan -->
                    <li class="nav-small-cap">
                        <i class="fas fa-folder nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Kelola Laporan</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs("report.categories") ? "active" : "" }}"
                            href="{{ route("report.categories") }}">
                            <i class="fas fa-folder me-2"></i>
                            <span class="hide-menu">Data Kategori</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs("report.products") ? "active" : "" }}"
                            href="{{ route("report.products") }}">
                            <i class="fas fa-box-open me-2"></i>
                            <span class="hide-menu">Data Produk</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs("report.customers") ? "active" : "" }}"
                            href="{{ route("report.customers") }}">
                            <i class="fas fa-user-friends me-2"></i>
                            <span class="hide-menu">Data Pelanggan</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs("report.transactions") ? "active" : "" }}"
                            href="{{ route("report.transactions") }}">
                            <i class="fas fa-file-invoice me-2"></i>
                            <span class="hide-menu">Data Transaksi</span>
                        </a>
                    </li>

                    <li><span class="sidebar-divider lg"></span></li>
                @elseif (auth()->user()->role === "admin")
                    <!-- Section: Menu Karyawan -->
                    <li class="nav-small-cap">
                        <i class="fas fa-user-tie nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Menu Karyawan</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs("customers") ? "active" : "" }}"
                            href="{{ route("customers") }}">
                            <i class="fas fa-users me-2"></i>
                            <span class="hide-menu">Pelanggan</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs("products.index") ? "active" : "" }}"
                            href="{{ route("products.index") }}">
                            <i class="fas fa-boxes me-2"></i>
                            <span class="hide-menu">Produk Toko</span>
                        </a>
                    </li>
                    <li class="sidebar-item position-relative">
                        <a class="sidebar-link {{ request()->routeIs("transactions.index") ? "active" : "" }}"
                            href="{{ route("transactions.index") }}">
                            <i class="fas fa-exchange-alt me-2"></i>
                            <span class="hide-menu">Transaksi</span>
                        </a>
                        @if ($orders > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $orders }}
                            </span>
                        @endif
                    </li>

                    <li><span class="sidebar-divider lg"></span></li>

                    <!-- Section: Laporan -->
                    <li class="nav-small-cap">
                        <i class="fas fa-folder nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Kelola Laporan</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs("report.transactions") ? "active" : "" }}"
                            href="{{ route("report.transactions") }}">
                            <i class="fas fa-file-invoice me-2"></i>
                            <span class="hide-menu">Data Transaksi</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endvolt

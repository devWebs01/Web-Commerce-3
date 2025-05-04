<?php

use App\Livewire\Actions\Logout;

$logout = function (Logout $logout) {
    $logout();
    $this->redirect("/");
};
?>

@volt
    <div>
       
        <button wire:click="logout" class="d-flex align-items-center gap-2 dropdown-item">
            <i class="ti ti-logout fs-6"></i>
            <p class="mb-0 fs-3">Keluar</p>
        </button>
    </div>
@endvolt

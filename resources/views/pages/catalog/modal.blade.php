<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-body">
                <h6 class="mb-3">
                    Pesanan akan dikirim ke
                </h6>
                <h6 class="text-dark mb-3">{{ auth()->user()->fulladdress }}</h6>
                <h6>
                    Apakah alamat pengiriman ini sudah benar?
                </h6>
            </div>
            <div class="modal-footer d-flex justify-content-around border-0">
                <a class="btn btn-outline-danger" href="{{ route("customer.account", ["user" => auth()->id()]) }}"
                    role="button">
                    Tidak, Ubah Alamat
                </a>

                <form wire:submit="confirmCheckout">
                    <button wire:loading.attr='disable' type="submit" class="btn btn-outline-dark">
                        <span wire:loading.delay wire:target="confirmCheckout"
                            class="loading loading-spinner loading-xs"></span>
                        Ya, Konfirmasi Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

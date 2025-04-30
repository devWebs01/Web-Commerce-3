<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h6>Pesanan akan dikirim ke
                    <br>
                    <small style="color: #635bff;">{{ auth()->user()->fulladdress }}</small>
                    <br>
                    <strong>
                        Apakah alamat pengiriman tersebut sudah benar?
                    </strong>
                </h6>
            </div>
            <div class="modal-footer d-flex justify-content-around">
                <a class="btn btn-dark btn-sm" href="{{ route("customer.account", ["user" => auth()->id()]) }}"
                    role="button">
                    Tidak, Atur Alamat
                </a>

                <form wire:submit="confirmCheckout">
                    <button wire:loading.attr='disable' type="submit" class="btn btn-sm btn-dark">
                        <span wire:loading.delay wire:target="confirmCheckout"
                            class="loading loading-spinner loading-xs"></span>
                        Ya, Lanjut
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

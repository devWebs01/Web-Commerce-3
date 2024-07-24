{{-- <table id="example" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Age</th>
            <th>Start date</th>
            <th>Salary</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Tiger Nixon</td>
            <td>System Architect</td>
            <td>Edinburgh</td>
            <td>61</td>
            <td>2011-04-25</td>
            <td>$320,800</td>
        </tr>
    </tbody>
</table> --}}

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.6.0/css/searchBuilder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.1/css/dataTables.dateTime.min.css">
    <style>
        table.dataTable thead tr,
        table.dataTable thead th,
        table.dataTable tbody th,
        table.dataTable tbody td {
            text-align: center;
        }

        /* mode dark */
        .pagination .page-item.disabled .page-link {
            color: #fff;
            /* Set disabled link text color to white */
            background-color: #323349;
            /* Set disabled link background color to match paginate background */
        }

        .pagination .page-item .page-link:hover {
            color: #fff;
            /* Set link text color to white on hover */
            background-color: #6c757d;
            /* Set link background color on hover */
            border-color: #6c757d;
            /* Set link border color on hover */
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.6.0/js/dataTables.searchBuilder.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script>
        $('.table').DataTable({
            dom: 'QBfrtip',
            buttons: [
                'excel', {
                    extend: 'print',
                    orientation: 'landscape',
                    title: '',
                    pageSize: 'A4',
                    messageTop:'<div class="container"> <h1 class="text-header"><strong>Laporan Data Bylilian</strong></h1> </div> <hr class="garis1" /> </header> <style> body { text-align: center; } h1, h3, h5, h6 { padding-right: 100px; } .row { margin-top: 20px; } .text-header { font-size: 24px; font-size: 3vw; } .garis1 { border-top: 3px solid black; height: 2px; border-bottom: 1px solid black; } .container { display: flex; justify-content: flex-end; text-align: end; width: 100%; /* Menggunakan 80% dari lebar untuk meniru col-10 */ margin: 0 auto; /* Agar berada di tengah */ } </style>',
                    customize: function(win) {
                        $(win.document.body).find('table')
                            .css('font-size', '8pt');
                    }
                }
            ]
        });
    </script>
@endpush

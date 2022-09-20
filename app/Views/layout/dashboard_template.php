<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?= $title ?> - Surya Kontruksindo Utama</title>
        <link rel="shortcut icon" href="<?= base_url('/assets/img/logo_square.jpg') ?>" type="image/x-icon">
        <link href="css/styles.css" rel="stylesheet" />
        <!-- LIGHTBOX -->
        <link rel="stylesheet" href="<?= base_url('/css/lightbox.css') ?>">
        <!-- DATATABLES -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
        <!-- TOASTR -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <!-- SELECT2 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <!-- Or for RTL support -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <?= $this->include('layout/dashboard_header') ?>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                    <?= $this->include('layout/dashboard_sidenav') ?> 
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <?= $this->renderSection('content') ?>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <?= $this->include('layout/dashboard_footer') ?> 
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <!-- MOMENT -->
        <script src="<?= base_url('/js/moment.js') ?>"></script>
        <script>
            $( document ).ready(function() {
                let a = moment().format('HH');

                if(a > 23) {
                    $('#time_users').text('Selamat Pagi');
                } else if(a > 10) {
                    $('#time_users').text('Selamat Siang');
                } else if(a > 15) {
                    $('#time_users').text('Selamat Sore');
                } else if(a > 18) {
                    $('#time_users').text('Selamat Malam');
                }
            });
        </script>
        <!-- CHARTJS -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
        <?php if($title == 'Dashboard' && session()->get('role') != 'teknisi') : ?>
            <script>
            const ctx = document.getElementById('chart_peminjaman').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Barang Dipinjam', 'Barang Dikembalikan'],
                    datasets: [{
                        label: '',
                        data: [<?= $count_dipinjam ?>, <?= $count_dikembalikan ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                        display: false
                        }
                    }
                }
            });

            const ctx2 = document.getElementById('chart_karyawan').getContext('2d');
            const myChart2 = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: [
                        <?php foreach($grafik_karyawans as $data) : ?>
                            "<?= $data['nama'] ?>",
                        <?php endforeach; ?>
                    ],
                    datasets: [{
                        label: '',
                        data: [
                            <?php foreach($grafik_karyawans as $data) : ?>
                                "<?= $data['jumlah'] ?>",
                            <?php endforeach; ?>
                        ],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                        display: false
                        }
                    }
                }
            });

            const ctx3 = document.getElementById('chart_barang').getContext('2d');
            const myChart3 = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: [
                        <?php foreach($grafik_barangs as $data) : ?>
                            "<?= $data['nama_barang'] ?>",
                        <?php endforeach; ?>
                    ],
                    datasets: [{
                        label: '',
                        data: [
                            <?php foreach($grafik_barangs as $data) : ?>
                                "<?= $data['qty_barang'] ?>",
                            <?php endforeach; ?>
                        ],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                        display: false
                        }
                    }
                }
            });
            </script>
        <?php endif; ?>
        <!-- DATATABLES -->
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#example').DataTable();
            });

            $(document).ready(function () {
                $('#example2').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        { extend: 'excel', className: 'btn-primary' },
                        { extend: 'pdf', className: 'btn-primary' },
                    ]
                });
            });
        </script>
        <!-- LIGHTBOX -->
        <script src="<?= base_url('/js/lightbox.js') ?>"></script>
        <!-- SELECT2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
        <script>
            $('#basic-usage').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                dropdownParent: $("#modalTambahRequest")
            });
            $('#basic-usage2').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                dropdownParent: $(".modalAlihkan")
            });
        </script>
        <!-- TOASTR -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script type="text/javascript">
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            <?php if(session()->get('success')){ ?>
                toastr.success("<?= session()->get('success'); ?>");
            <?php }else if(session()->get('error')){  ?>
                toastr.error("<?= session()->get('error'); ?>");
            <?php }else if(session()->get('warning')){  ?>
                toastr.warning("<?= session()->get('warning'); ?>");
            <?php }else if(session()->get('info')){  ?>
                toastr.info("<?= session()->get('info'); ?>");
            <?php } ?>
        </script>

        <!-- CUSTOM -->
        <script>
            function setMaxSum() {
                var val = $("#basic-usage");
                var jumlahMax = val.children(":selected").attr("id");
                return $('#jumlah').attr('max', jumlahMax);
            }
        </script>
    </body>
</html>
<div class="sb-sidenav-menu">
    <div class="nav">
        <div class="sb-sidenav-menu-heading">Menu</div>
        <a class="nav-link <?= $title == 'Dashboard' ? 'active' : '' ?>" href="<?= base_url('/') ?>">
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
            Dashboard
        </a>
        <?php if(session()->get('role') == 'master') : ?>
        <a class="nav-link collapsed <?= $title == 'Barang' || $title == 'Kategori' || $title == 'Karyawan' ? 'active' : '' ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
            Master Data
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link <?= $title == 'Kategori' ? 'active' : '' ?>" href="<?= base_url('/kategori') ?>">Kategori</a>
                <a class="nav-link <?= $title == 'Barang' ? 'active' : '' ?>" href="<?= base_url('/barang') ?>">Barang</a>
                <a class="nav-link <?= $title == 'Karyawan' ? 'active' : '' ?>" href="<?= base_url('/karyawan') ?>">Karyawan</a>
            </nav>
        </div>
        <a class="nav-link <?= $title == 'Aktivitas Karyawan' ? 'active' : '' ?>" href="<?= base_url('/activity-all') ?>">
            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
            Aktivitas User
        </a>
        <?php endif; ?>

        <?php if(session()->get('role') != 'master') : ?>
        <a class="nav-link collapsed <?= $title == 'Permintaan' || $title == 'Peminjaman' ? 'active' : '' ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts2">
            <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>
            Proses
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link <?= $title == 'Permintaan' ? 'active' : '' ?>" href="<?= base_url('/permintaan') ?>">Permintaan</a>
                <a class="nav-link <?= $title == 'Peminjaman' ? 'active' : '' ?>" href="<?= base_url('/peminjaman') ?>">Peminjaman</a>
            </nav>
        </div>
        <?php endif; ?>

        <?php if(session()->get('role') == 'admin') : ?>
        <a class="nav-link" href="index.html">
            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
            Laporan
        </a>
        <?php endif; ?>
    </div>
</div>
<div class="sb-sidenav-footer">
    <div class="small">Login sebagai:</div>
    <?= session()->get('role') ?>
</div>
<?= $this->extend('templates/header') ?>
<?= $this->section('content') ?>

<section style="text-align:center; padding:5rem;">
    <h2>Terima kasih!</h2>
    <p>Pesanan Anda telah kami terima. 😊</p>
    <a href="<?= site_url('menu') ?>" style="padding:10px 20px; background:#e74c3c; color:white; border-radius:8px; text-decoration:none;">
        Kembali ke Menu
    </a>
</section>

<?= $this->endSection() ?>

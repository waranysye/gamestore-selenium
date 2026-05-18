<?php
/**
 * @var array $game
 * @var array $images
 * @var bool  $inCart
 * @var bool  $owned
 * @var bool  $downloaded
 */

$isLoggedIn = session()->get('user_id');
?>

<?= $this->extend('Layouts/user') ?>
<?= $this->section('content') ?>

<?php
$inCart     = $inCart ?? false;
$owned      = $owned ?? false;
$downloaded = $downloaded ?? false;
?>

<main class="px-6 py-8">

    <button onclick="history.back()"
        class="mb-6 inline-flex items-center gap-2 text-slate-400 hover:text-primary">
        ← Back
    </button>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- LEFT -->
        <div class="lg:col-span-2 space-y-8">

            <div class="bg-slate-900 rounded-xl p-4">
                <img id="mainImage"
                     src="<?= base_url('uploads/games/' . ($images[0]['image_path'] ?? $game['cover_image'])) ?>"
                     class="w-full h-72 object-cover rounded-lg mb-4">

                <?php if (!empty($images)): ?>
                <div class="flex gap-3 overflow-x-auto">
                    <?php foreach ($images as $img): ?>
                        <img src="<?= base_url($img['image_path']) ?>"
                             onclick="changeImage(this.src)"
                             class="w-24 h-16 object-cover rounded cursor-pointer hover:ring-2 hover:ring-primary">
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <section>
                <h2 class="text-2xl font-bold mb-4">About This Game</h2>
                <p class="text-slate-300 leading-relaxed">
                    <?= nl2br(esc((string)$game['description'])) ?>
                </p>
            </section>

        </div>

        <!-- RIGHT -->
        <aside class="bg-slate-900 rounded-xl p-6 h-fit sticky top-24">

            <img src="<?= base_url('uploads/games/' . ($game['cover_image'] ?? 'default.png')) ?>"
                 class="w-full h-48 object-cover rounded mb-5">

            <h1 class="text-2xl font-bold mb-2">
                <?= esc($game['title']) ?>
            </h1>

            <p class="text-slate-400 mb-5">
                <?= esc($game['category_name']) ?>
            </p>

            <p class="text-3xl font-bold text-green-400 mb-6">
                <?php if ($owned): ?>
                    Owned
                <?php else: ?>
                    Rp <?= number_format($game['price'], 0, ',', '.') ?>
                <?php endif; ?>
            </p>

            <!-- NOT LOGIN -->
            <?php if (!$isLoggedIn): ?>

                <a href="<?= site_url('login') ?>"
                   class="block w-full text-center bg-slate-700 text-white py-3 rounded-lg">
                    Login to Buy
                </a>

            <?php else: ?>

                <!-- OWNED -->
                <?php if ($owned): ?>

                    <a href="<?= base_url('library') ?>"
                       class="block w-full text-center bg-primary hover:bg-blue-600 text-white py-3 rounded-lg font-semibold mb-3">
                        Go to Library
                    </a>

                    <?php if ($downloaded): ?>

                        <form action="<?= base_url('library/uninstall/'.$game['id']) ?>" method="post" class="action-form" id="uninstallForm">
                            <?= csrf_field() ?>
                            <button class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg">
                                Uninstall
                            </button>
                        </form>

                    <?php else: ?>

                        <form action="<?= base_url('library/download/'.$game['id']) ?>" method="post" class="action-form" id="downloadForm">
                            <?= csrf_field() ?>
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg">
                                Download
                            </button>
                        </form>

                    <?php endif; ?>

                <!-- NOT OWNED -->
                <?php else: ?>

                    <form action="<?= base_url('checkout/buyNow'); ?>" method="post" class="mb-3 action-form" id="buyNowForm">
                        <?= csrf_field() ?>
                        <input type="hidden" name="game_id" value="<?= $game['id'] ?>">

                        <button class="buy-now w-full bg-primary hover:bg-blue-600 text-white py-3 rounded-lg">
                            Buy Now
                        </button>
                    </form>

                    <?php if ($inCart): ?>
                        <button disabled class="w-full bg-slate-700 text-slate-400 py-3 rounded-lg">
                            Already in Cart
                        </button>
                    <?php else: ?>
                        <form action="<?= site_url('cart/add/' . $game['id']) ?>" method="post" class="action-form" id="addToCartForm">
                            <?= csrf_field() ?>

                            <button class="add-to-cart w-full bg-slate-800 hover:bg-slate-700 text-white py-3 rounded-lg flex justify-center gap-2">
                                <i class="fa-solid fa-cart-shopping"></i>
                                Add to Cart
                            </button>

                        </form>
                    <?php endif; ?>

                <?php endif; ?>

            <?php endif; ?>

        </aside>

    </div>
</main>

<script>
function changeImage(src) {
    document.getElementById('mainImage').src = src;
}

document.querySelectorAll('.action-form').forEach(form => {
    form.addEventListener('submit', function () {
        const btn = this.querySelector('button');
        btn.innerText = 'Processing...';
        btn.disabled = true;
    });
});
</script>

<?= $this->endSection() ?>
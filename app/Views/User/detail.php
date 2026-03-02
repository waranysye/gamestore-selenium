<?php
/**
 * @var array $game
 * @var array $images
 * @var bool  $inCart
 */
?>

<?= $this->extend('Layouts/user') ?>

<?= $this->section('content') ?>

<?php $inCart = $inCart ?? false; ?>

<main class="px-6 py-8">

    <!-- BACK -->
    <button onclick="history.back()"
        class="mb-6 inline-flex items-center gap-2 text-slate-400 hover:text-primary">
        ← Back
    </button>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- LEFT -->
        <div class="lg:col-span-2 space-y-8">

            <!-- GALLERY -->
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

            <!-- ABOUT -->
            <section>
                <h2 class="text-2xl font-bold mb-4">About This Game</h2>
                <p class="text-slate-300 leading-relaxed">
                    <?= nl2br(esc((string)$game['description'])) ?>
                </p>
            </section>

        </div>

        <!-- RIGHT CARD -->
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
                Rp <?= number_format($game['price'], 0, ',', '.') ?>
            </p>

            <!-- BUY NOW -->
            <form action="<?= base_url('checkout/buyNow'); ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                <button type="submit"
                        class="w-full bg-primary hover:bg-blue-600 text-white py-3 rounded-lg font-semibold transition">
                    Buy Now
                </button>
            </form>

            <!-- ADD TO CART -->
            <?php if ($inCart): ?>
                <button disabled
                        class="w-full bg-slate-700 text-slate-400 py-3 rounded-lg cursor-not-allowed">
                    Already in Cart
                </button>
            <?php else: ?>
                <form action="<?= site_url('cart/add/' . $game['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit"
        class="w-full bg-slate-800 hover:bg-slate-700 text-white py-3 rounded-lg transition flex items-center justify-center gap-2 hover:scale-[1.02] active:scale-[0.98]">
    <i class="fa-solid fa-cart-shopping"></i>
    Add to Cart
</button>
                </form>
            <?php endif; ?>

        </aside>

    </div>
</main>

<script>
function changeImage(src) {
    document.getElementById('mainImage').src = src;
}
</script>

<?= $this->endSection() ?>
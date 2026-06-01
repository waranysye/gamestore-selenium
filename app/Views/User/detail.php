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

    <?php
    $isLoggedIn = $isLoggedIn ?? false;
    $mainImage = !empty($images) ? base_url('uploads/games/gallery/' . $images[0]['image']) : base_url('uploads/games/' . ($game['cover_image'] ?? 'default.png'));
    $fileName  = trim((string)$game['game_file']) ?: 'N/A';
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    $format    = $extension ? strtoupper($extension) : 'Digital';
    $fileSize  = !empty($game['size']) ? number_format($game['size']) . ' MB' : 'Unknown';
    $isNew     = !empty($game['created_at']) && strtotime($game['created_at']) > strtotime('-30 days');
    $rating    = 4.7;
    $reviews   = 12;
    ?>

    <div class="flex flex-col gap-4 mb-6">
        <button onclick="history.back()" class="inline-flex items-center gap-2 text-slate-400 hover:text-primary">
            <i class="fa-solid fa-arrow-left"></i> Back to store
        </button>
        <div class="flex flex-wrap items-center gap-3 text-sm text-slate-300">
            <span class="px-3 py-1 rounded-full bg-slate-800 text-slate-200">Store</span>
            <span class="px-3 py-1 rounded-full bg-slate-800 text-slate-200"><?= esc($game['category_name']) ?></span>
            <?php if ($isNew): ?>
                <span class="px-3 py-1 rounded-full bg-emerald-600 text-white">New Arrival</span>
            <?php endif; ?>
            <span class="px-3 py-1 rounded-full bg-slate-800 text-slate-200">Size: <?= esc($fileSize) ?></span>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-[2fr_1fr] gap-10">

        <section class="space-y-8">
            <div class="bg-slate-900 rounded-[32px] overflow-hidden shadow-xl shadow-black/20">
                <div class="relative">
                    <img id="mainImage" src="<?= esc($mainImage) ?>" class="w-full h-[520px] object-cover" alt="<?= esc($game['title']) ?>">
                    <button onclick="openLightbox('<?= esc($mainImage) ?>')" class="absolute right-4 top-4 bg-black/60 text-white rounded-full p-3 hover:bg-black">Preview</button>
                </div>

                <div class="bg-slate-950 p-5 space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h1 class="text-4xl font-semibold mb-2"><?= esc($game['title']) ?></h1>
                            <div class="flex flex-wrap items-center gap-2 text-sm text-slate-400">
                                <span><?= esc($game['category_name']) ?></span>
                                <span class="h-1 w-1 rounded-full bg-slate-600"></span>
                                <span><?= $owned ? ($downloaded ? 'Installed' : 'Owned') : 'Ready to purchase' ?></span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <p class="text-4xl font-bold text-emerald-400"><?= $owned ? 'Owned' : 'Rp ' . number_format($game['price'], 0, ',', '.') ?></p>
                                <?php if (!$owned): ?>
                                    <p class="text-xs text-slate-500">Secure checkout</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-3 lg:grid-cols-[1fr_320px]">
                        <div class="space-y-3">
                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-2 rounded-full bg-slate-800 text-slate-200">Best Seller</span>
                                <span class="px-3 py-2 rounded-full bg-slate-800 text-slate-200">Top Choice</span>
                                <span class="px-3 py-2 rounded-full bg-slate-800 text-slate-200">Fast Download</span>
                            </div>

                            <div class="grid gap-3 md:grid-cols-2">
                                <?php if (!empty($images)): ?>
                                    <?php foreach ($images as $img): ?>
                                        <button type="button" onclick="openLightbox('<?= base_url('uploads/games/gallery/' . $img['image']) ?>');"
                                                class="w-full overflow-hidden rounded-3xl border border-slate-800 hover:border-primary transition-all duration-200">
                                            <img src="<?= base_url('uploads/games/gallery/' . $img['image']) ?>"
                                                 class="w-full h-32 object-cover">
                                        </button>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="rounded-3xl bg-slate-800 p-6">
                            <h2 class="text-xl font-semibold mb-4">Quick Specs</h2>
                            <ul class="space-y-3 text-sm text-slate-300">
                                <li><strong>Platform:</strong> Windows</li>
                                <li><strong>Format:</strong> <?= esc($format) ?></li>
                                <li><strong>File size:</strong> <?= esc($fileSize) ?></li>
                                <li><strong>Game file:</strong> <?= esc($fileName) ?></li>
                                <li><strong>Gallery:</strong> <?= count($images) ?> screenshot<?= count($images) === 1 ? '' : 's' ?></li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-slate-950 rounded-3xl p-6">
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <div>
                                <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Game summary</p>
                                <h2 class="text-2xl font-semibold">About this game</h2>
                            </div>
                            <div class="flex items-center gap-2 text-slate-400">
                                <span class="text-lg font-semibold text-amber-400"><?= number_format($rating, 1) ?></span>
                                <span>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fa-solid fa-star <?= $i <= floor($rating) ? 'text-amber-400' : 'text-slate-700' ?>"></i>
                                    <?php endfor; ?>
                                </span>
                            </div>
                        </div>
                        <div class="text-slate-300 leading-relaxed">
                            <?= nl2br(esc((string)$game['description'])) ?>
                        </div>

                        <div class="mt-8 grid gap-4 md:grid-cols-3">
                            <div class="rounded-3xl bg-slate-900 p-4">
                                <h3 class="text-sm uppercase tracking-[0.2em] text-slate-500">Performance</h3>
                                <p class="mt-3 text-sm text-slate-300">Smooth loading and lightweight gameplay experience for modern PCs.</p>
                            </div>
                            <div class="rounded-3xl bg-slate-900 p-4">
                                <h3 class="text-sm uppercase tracking-[0.2em] text-slate-500">Multiplayer</h3>
                                <p class="mt-3 text-sm text-slate-300">Suitable for solo or group play with fast matchmaking.</p>
                            </div>
                            <div class="rounded-3xl bg-slate-900 p-4">
                                <h3 class="text-sm uppercase tracking-[0.2em] text-slate-500">Support</h3>
                                <p class="mt-3 text-sm text-slate-300">24/7 support and patch updates included.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($relatedGames)): ?>
            <section class="bg-slate-900 rounded-[32px] p-6 shadow-xl shadow-black/10">
                <div class="flex items-center justify-between mb-6 gap-4">
                    <div>
                        <p class="text-sm uppercase tracking-[0.24em] text-slate-500">You may also like</p>
                        <h2 class="text-2xl font-semibold">Related games</h2>
                    </div>
                    <span class="text-sm text-slate-400"><?= count($relatedGames) ?> recommendations</span>
                </div>
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <?php foreach ($relatedGames as $related): ?>
                        <a href="<?= base_url('game/' . $related['id']) ?>" class="block rounded-3xl overflow-hidden bg-slate-950 transition hover:-translate-y-1">
                            <img src="<?= base_url('uploads/games/' . ($related['cover_image'] ?: 'default.png')) ?>" class="h-44 w-full object-cover">
                            <div class="p-4">
                                <h3 class="font-semibold mb-1"><?= esc($related['title']) ?></h3>
                                <p class="text-sm text-slate-400">Rp <?= number_format($related['price'], 0, ',', '.') ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
        </section>

        <aside class="space-y-6">
            <div class="rounded-[32px] bg-slate-900 p-6 shadow-xl shadow-black/20">
                <h2 class="text-xl font-semibold mb-4">Checkout Summary</h2>
                <div class="space-y-4 text-sm text-slate-300">
                    <div class="flex items-center justify-between">
                        <span>Price</span>
                        <span class="font-semibold"><?= $owned ? 'Owned' : 'Rp ' . number_format($game['price'], 0, ',', '.') ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Platform</span>
                        <span>Windows</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Download</span>
                        <span><?= count($images) ? 'Gallery ready' : 'Cover only' ?></span>
                    </div>
                </div>
            </div>

            <div class="rounded-[32px] bg-slate-900 p-6 shadow-xl shadow-black/20">
                <h2 class="text-xl font-semibold mb-4">Purchase Options</h2>
                <?php if (!$isLoggedIn): ?>
                    <a href="<?= base_url('login') ?>" class="block text-center bg-primary hover:bg-blue-600 text-white py-4 rounded-3xl font-semibold">
                        Login untuk membeli
                    </a>
                <?php else: ?>
                    <?php if ($owned): ?>
                        <?php if ($downloaded): ?>
                            <a href="<?= base_url('download/game/' . $game['id']) ?>" class="block text-center bg-emerald-500 hover:bg-emerald-600 text-white py-4 rounded-3xl font-semibold">
                                Download Ulang
                            </a>
                        <?php else: ?>
                            <form action="<?= base_url('library/download/' . $game['id']) ?>" method="post" class="action-form">
                                <?= csrf_field() ?>
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-3xl font-semibold">
                                    Install & Download
                                </button>
                            </form>
                        <?php endif; ?>

                        <a href="<?= base_url('library') ?>" class="block text-center mt-3 bg-slate-700 hover:bg-slate-600 text-white py-4 rounded-3xl font-semibold">
                            Buka Library
                        </a>
                    <?php else: ?>
                        <form action="<?= base_url('checkout/buyNow') ?>" method="post" class="action-form mb-3">
                            <?= csrf_field() ?>
                            <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                            <button type="submit" class="w-full bg-primary hover:bg-blue-600 text-white py-4 rounded-3xl font-semibold">
                                Buy Now
                            </button>
                        </form>

                        <?php if ($inCart): ?>
                            <a href="<?= base_url('cart') ?>" class="block text-center bg-slate-700 hover:bg-slate-600 text-white py-4 rounded-3xl font-semibold">
                                Already in Cart
                            </a>
                        <?php else: ?>
                            <form action="<?= base_url('cart/add/' . $game['id']) ?>" method="post" class="action-form">
                                <?= csrf_field() ?>
                                <button type="submit" class="w-full bg-slate-800 hover:bg-slate-700 text-white py-4 rounded-3xl font-semibold">
                                    Add to Cart
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="rounded-[32px] bg-slate-900 p-6 shadow-xl shadow-black/10">
                <h2 class="text-xl font-semibold mb-4">Customer Reviews</h2>
                <div class="flex items-center gap-3 mb-4">
                    <div class="text-4xl font-bold text-amber-400"><?= number_format($rating, 1) ?></div>
                    <div>
                        <div class="flex gap-1 text-amber-400">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fa-solid fa-star <?= $i <= floor($rating) ? 'text-amber-400' : 'text-slate-700' ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="text-sm text-slate-400"><?= $reviews ?> reviews</p>
                    </div>
                </div>
                <div class="rounded-3xl bg-slate-950 p-4 text-sm text-slate-400">
                    <p class="mb-3">"Experience is smooth and visually stunning. Highly recommended for casual and core players."</p>
                    <p class="font-semibold text-slate-200">- Player Review</p>
                </div>
            </div>
        </aside>
    </div>

    <div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/85 p-6">
        <button onclick="closeLightbox()" class="absolute right-6 top-6 text-4xl text-white">&times;</button>
        <img id="lightboxImage" class="max-h-full max-w-full rounded-3xl shadow-2xl" alt="Preview">
    </div>
</main>

<script>
function changeImage(src) {
    document.getElementById('mainImage').src = src;
}

function openLightbox(src) {
    document.getElementById('lightboxImage').src = src;
    document.getElementById('lightbox').classList.remove('hidden');
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
}

document.querySelectorAll('.action-form').forEach(form => {
    form.addEventListener('submit', function () {
        const btn = this.querySelector('button');
        if (btn) {
            btn.innerText = 'Processing...';
            btn.disabled = true;
        }
    });
});
</script>

<?= $this->endSection() ?>
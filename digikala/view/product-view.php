<div class="dk">
    <div class="dk_right">
        <div class="dk_colors">
            <?php foreach ($product->colors as $color) : ?>
                <div class="dk_color">
                    <span style="color: red;" <?= esc_attr($color->hex_code); ?>>رنگ</span>
                    <?= esc_html($color->title) ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="dk_thumbnail">
            <img src="<?= esc_attr($product->images->main->url[0]); ?>">
        </div>
    </div>
    <div class="dk_left">
        <h2>
            <?= esc_html($product->title_fa); ?>
        </h2>
        <div class="dk_description">
            <?= esc_html($product->review->description); ?>
        </div>
    </div>
    <div class="dk_right">
        <div class="dk_thumbnails">
            <img src="<?= esc_attr($product->images->main->url[0]); ?>" class="active">
            <?php foreach ($product->images->list as $thumbnails) : ?>
                <img src="<?= esc_attr($thumbnails->url[0]); ?>">
            <?php endforeach; ?>
        </div>
    </div>
    <div class="dk_left">
        <footer>
            <div class="dk_footer_left">
                <?php if ($discount) : ?>
                    <span class="dk_discount"><?= $discount; ?></span>
                    <del><?= number_format($price / 10); ?></del>
                <?php endif; ?>
                <ins><?= number_format($sale_price / 10); ?></ins>
                <span class="dk_currency">تومان</span>
            </div>
            <a href="<?php esc_attr('https://digikala.com/' . $product->url->uri); ?> ">مشاهده و خرید</a>
        </footer>
    </div>
</div>
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="<?= $page['headerIcon'] ?>"></i>
            </div>
            <div><?= $page['title'] ?>
                <div class="page-title-subheading"><?= $page['description'] ?>
                </div>
            </div>
        </div>
        <?php include_once(VIEW_LAYOUT_DIR.'main/page-title-action.php') ?>
    </div>
</div>
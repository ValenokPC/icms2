<div class="icms-content-header">
    <div class="icms-bg__cover icms-content-header__banner <?php if ($image_is_parallax){ ?>parallax-window<?php } ?>" <?php if ($image_is_parallax){ ?>data-parallax="scroll" data-image-src="<?php echo $image_src; ?>"<?php } else { ?>style="background-image: url(<?php echo $image_src; ?>)"<?php } ?>>
        <div class="container py-5 position-relative">
            <?php foreach ($fields as $field) { ?>
                <div class="icms-content-header__field ft_<?php echo $field['type']; ?> f_<?php echo $field['name']; ?>">
                    <?php echo $field['html']; ?>
                </div>
            <?php } ?>
            <?php if ($show_info_block && !empty($item['info_bar'])){ ?>
                <div class="info_bar d-flex bg-transparent p-0 border-0 mt-1 text-white">
                    <?php foreach($item['info_bar'] as $bar){ ?>
                        <div class="bar_item mr-3 text-truncate <?php echo !empty($bar['css']) ? $bar['css'] : ''; ?>" title="<?php html(!empty($bar['title']) ? $bar['title'] : ''); ?>">
                            <?php if (!empty($bar['icon'])){ ?>
                                <?php html_svg_icon('solid', $bar['icon']); ?>
                            <?php } ?>
                            <?php if (!empty($bar['href'])){ ?>
                                <a class="stretched-link" href="<?php echo $bar['href']; ?>"><?php echo $bar['html']; ?></a>
                            <?php } else { ?>
                                <?php echo $bar['html']; ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php if ($image_is_parallax){
	$this->addTplJSNameFromContext([
        'vendors/parallax/parallax.min'
    ]);
} ?>

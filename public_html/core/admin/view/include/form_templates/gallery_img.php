<div class="vg-element vg-full vg-box-shadow img_wrapper">
	<div class="vg-wrap vg-element vg-full">
		<div class="vg-wrap vg-element vg-full">
			<div class="vg-element vg-full vg-left">
				<span class="vg-header"><?= $this->translate[$row][0] ?: $row ?></span>
			</div>
			<div class="vg-element vg-full vg-left">
				<span class="vg-text vg-firm-color5"><?= $this->translate[$row][1] ?></span><span class="vg_subheader"></span>
			</div>
		</div>
		<div class="vg-wrap vg-element vg-full gallery_container">
			<label class="vg-dotted-square vg-center" draggable="false">
				<img src="<?= PATH . ADMIN_TEMPLATE ?>img/add.png" alt="plus" draggable="false">
				<input class="gallery_img" style="display: none;" type="file" name="<?= $row ?>[]" multiple="" accept="image/*,image/jpeg,image/png,image/gif" draggable="false">
			</label>

			<?php if ($this->data[$row]) : ?>

				<?php $this->data[$row] = json_decode($this->data[$row]); ?>

				<?php foreach ($this->data[$row] as $item) : ?>

					<a href="/admin/delete/goods/53/gallery_img/Zm90bzEucG5n" class="vg-dotted-square vg-center" draggable="true">
						<img class="vg_delete" src="<?= PATH . UPLOAD_DIR . $item ?>" draggable="false">
					</a>

				<?php endforeach; ?>

				<?php

				for ($i = 0; $i < 2; $i++) {

					echo '<div class="vg-dotted-square vg-center empty_container" draggable="false"></div>';
				}

				?>

			<?php else : ?>

				<?php

				for ($i = 0; $i < 6; $i++) {

					echo '<div class="vg-dotted-square vg-center empty_container" draggable="false"></div>';
				}

				?>

			<?php endif; ?>

			<!-- <div class="vg-dotted-square vg-center empty_container" draggable="false">
		</div>
		<div class="vg-dotted-square vg-center empty_container" draggable="false"></div> -->
		</div>
	</div>
</div>
<?php if (!empty($sales)) : ?>

	<section class="slider">
		<div class="slider__container swiper-container">

			<div class="slider__wrapper swiper-wrapper">

				<?php foreach ($sales as $item) : ?>

					<div class="slider__item swiper-slide">
						<div class="slider__item-description">
							<div class="slider__item-prev-text"><?= $item['sub_title'] ?></div>

							<!-- Сделаем вывод названия каждого слайда-->
							<div class="slider__item-header">

								<!-- <span>Интернет-магазин</span>
								<span>Автозапчастей</span> -->

								<?php foreach (preg_split('/\s+/', $item['name'], 0, PREG_SPLIT_NO_EMPTY) as $value) : ?>

									<span><?= $value ?></span>

								<?php endforeach; ?>

							</div>
							<div class="slider__item-text">

								<?= $this->clearStr($item['short_content']) ?>

							</div>

						</div>
						<div class="slider__item-image">
							<img src="<?= $this->img($item['img']) ?>" alt="<?= $item['name'] ?>">
						</div>
					</div>

				<?php endforeach; ?>

			</div>

			<div class="slider__pagination swiper-pagination"></div>
			<div class="slider__controls controls _prev swiper-button-prev">
				<svg>
					<use xlink:href="<?= PATH . TEMPLATE ?>assets/img/icons.svg#arrow"></use>
				</svg>
			</div>
			<div class="slider__controls controls _next swiper-button-next">
				<svg>
					<use xlink:href="<?= PATH . TEMPLATE ?>assets/img/icons.svg#arrow"></use>
				</svg>
			</div>
	</section>

<?php endif; ?>


<?php if (!empty($this->menu['catalog'])) : ?>

	<section class="catalog">
		<div class="division-internal__items">

			<?php foreach ($this->menu['catalog'] as $item) : ?>

				<a href="<?= $this->alias(['catalog' => $item['alias']]) ?>" class="division-internal-item">

					<span class="division-internal-item__title">
						<?= $item['name'] ?>
					</span>

					<span class="division-internal-item__arrow-stat">
						<svg>
							<use xlink:href="<?= PATH . TEMPLATE ?>assets/img/icons.svg#arrow-right"></use>
						</svg>
					</span>
					<span class="division-internal-item__arrow">
						<img src="<?= PATH . TEMPLATE ?>assets/img/divisions/devision-arrow.png" alt="">
					</span>
				</a>

			<?php endforeach; ?>

		</div>
	</section>

<?php endif; ?>


<?php if (!empty($goods) && !empty($arrHits)) : ?>

	<section class="offers">
		<div class="offers__tabs">
			<ul class="offers__tabs_header">

				<?php $activeItem = -1 ?>

				<?php foreach ($arrHits as $key => $item) : ?>

					<?php if (!empty($goods[$key])) : ?>

						<li class="<?= !++$activeItem ? 'active' : '' ?>">
							<div class="icon-offer"><?= $item['icon'] ?></div><?= $item['name'] ?>
						</li>

					<?php endif; ?>

				<?php endforeach; ?>

			</ul>

			<?php $activeItem = -1 ?>

			<?php foreach ($arrHits as $key => $value) : ?>

				<?php if (!empty($goods[$key])) : ?>

					<div class="offers__tabs_content <?= !++$activeItem ? 'active' : '' ?>">
						<div class="offers__tabs_subheader subheader">
							<?= $value['name'] ?>
						</div>
						<div class="offers__tabs_container swiper-container">
							<div class="offers__tabs_wrapper swiper-wrapper">

								<?php foreach ($goods[$key] as $item) {

									$this->showGoods($item, ['icon' => $value['icon']]);
								} ?>

							</div>
						</div>
						<a href="<?= $this->alias('catalog') ?>" class="offers__readmore readmore">Смотреть каталог</a>
					</div>

				<?php endif; ?>

			<?php endforeach; ?>

			<div class="offers__controls controls _prev">
				<svg>
					<use xlink:href="<?= PATH . TEMPLATE ?>assets/img/icons.svg#arrow"></use>
				</svg>
			</div>
			<div class="offers__controls controls _next">
				<svg>
					<use xlink:href="<?= PATH . TEMPLATE ?>assets/img/icons.svg#arrow"></use>
				</svg>
			</div>

		</div>
	</section>

<?php endif; ?>

<div class="horizontal">
	<div class="horizontal__wrapper">
		<section class="about">
			<div class="about__description">
				<div class="about__description_name subheader"><?= $this->set['name'] ?></div>
				<div class="about__description_text">

					<?= $this->set['short_content'] ?>

				</div>

			</div>

			<div class="about__image">

				<img src="<?= $this->img($this->set['promo_img']) ?>" alt="<?= $this->set['name'] ?>">

			</div>
		</section>

		<?php if (!empty($advantages)) : ?>

			<section class="advantages">
				<div class="advantages__name subheader">Наши преимущества</div>
				<div class="advantages__wrapper">

					<!-- Так как преимуществ два блока, то выводить их будем посредством счётчика (Выпуск №128) -->

					<?php $counter = 0 ?>

					<?php foreach ($advantages as $item) : ?>

						<?php if (!($counter % 3)) : ?>

							<div class="advantages__row <?= !$counter ? 'advantages__row_left' : 'advantages__row_right' ?>">

							<?php endif; ?>

							<?php $counter++ ?>

							<div class="advantages__item">

								<div class="advantages__item_header"><?= $item['name'] ?></div>

								<img src="<?= $this->img($item['img']) ?>" class="advantages__item_image" alt="">

							</div>

							<?php if (!($counter % 3)) : ?>

							</div>

						<?php endif; ?>

					<?php endforeach; ?>

					<?php if ($counter % 3) : ?>

				</div>

			<?php endif; ?>

	</div>
	</section>

<?php endif; ?>

</div>
</div>



<?php if (!empty($news)) : ?>

	<section class="news" id="news">
		<div class="news__name subheader">Новости</div>
		<div class="news__wrapper">

			<?php foreach ($news as $item) {

				$this->showGoods($item, [], 'newsItem');
			} ?>

		</div>

	</section>

<?php endif; ?>
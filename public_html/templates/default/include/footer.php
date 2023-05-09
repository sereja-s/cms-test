</main>

<?php if ($this->getController() === 'index') : ?>

	<div class="search search-internal" style="position: relative" id="searchButton">
		<button>
			<svg class="inline-svg-icon svg-search">
				<use xlink:href="<?= PATH . TEMPLATE ?>assets/img/icons.svg#search"></use>
			</svg>
		</button>
		<input type="search" name="search" placeholder="поиск">
		<input type="hidden" name="search_table" value="goods">
		<div class="dropdown-content search_res">
			<!-- <a href="#">Ссылка 1</a>
			<a href="#">Ссылка 2</a>
			<a href="#">Ссылка 3</a> -->
		</div>

		<style>
			.search-internal.vg-search-reverse .dropdown-content {
				display: block;
				z-index: 999999999;
				overflow: auto;
			}

			.dropdown-content {
				display: none;
				position: absolute;
				background-color: #f9f9f9;
				min-width: auto;
				box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
				z-index: 1;
				top: 55px;
				left: 55px;
			}

			/* Ссылки внутри выпадающего списка */
			.dropdown-content a {
				color: black;
				padding: 10px 15px;
				text-decoration: none;
				display: block;
			}

			/* Изменить цвет выпадающих ссылок при наведении */
			.dropdown-content a.search_act {
				background-color: #e5e5e5
			}
		</style>


	</div>

<?php endif; ?>

<footer class="footer">
	<div class="container">
		<div class="footer__wrapper">
			<div class="footer__top">
				<div class="footer__top_logo">
					<a href="<?= $this->alias() ?>"><img src="<?= $this->img($this->set['img']) ?>" alt="<?= $this->set['name'] ?>"></a>
					<!-- <img src="assets/img/Logo.svg" alt=""> -->
				</div>
				<div class="footer__top_menu">
					<ul>

						<?php if (!empty($this->menu['catalog'])) : ?>

							<li>
								<a href="<?= $this->alias('catalog') ?>"><span>Каталог</span></a>
							</li>

						<?php endif; ?>

						<?php if (!empty($this->menu['information'])) : ?>

							<?php foreach ($this->menu['information'] as $item) : ?>

								<li>
									<a href="<?= $this->alias(['information' => $item['alias']]) ?>"><span><?= $item['name'] ?></span></a>
								</li>

							<?php endforeach; ?>


						<?php endif; ?>

					</ul>
				</div>
				<div class="footer__top_contacts" id="contact">
					<div><a href="mailto:<?= $this->set['email'] ?>"><?= $this->set['email'] ?></a></div>
					<div><a href="tel:<?= preg_replace('/[^+\d]/', '', $this->set['phone']) ?>"><?= $this->set['phone'] ?></a></div>
				</div>
			</div>
		</div>
		<div class="footer__bottom" style="display: flex; justify-content: center; padding-bottom: 10px;">
			<div class="footer__bottom_copy"><a href="<?= $this->set['external_alias'] ?>" style="text-decoration: none;">SaitPostroen <?= $this->set['number_of_years'] ?></a></div>
		</div>
	</div>
</footer>

<div class="hide-elems">
	<svg>
		<defs>
			<linearGradient id="rainbow" x1="0" y1="0" x2="50%" y2="50%">
				<stop offset="0%" stop-color="#7282bc" />
				<stop offset="100%" stop-color="#7abfcc" />
			</linearGradient>
		</defs>
	</svg>
</div>

<!-- стрелка-вверх -->
<div class="arrow" id="arrowTop" hidden>
	<svg width="22" height="14" viewBox="0 0 22 14" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M21.22 10.61L10.61 -4.63778e-07L1.44357e-06 10.61L2.6288 13.2388L10.61 5.25759L18.5912 13.2388L21.22 10.61Z" fill="#445154" />
	</svg>
</div>

<?php $this->getScripts() ?>

<!-- Выпуск №147 -->
<!-- Выпуск №148 | Пользовательская часть | показ уведомлений пользователю -->
<?php if (!empty($_SESSION['res']['answer'])) : ?>

	<div class="wq-message__wrap"><?= $_SESSION['res']['answer'] ?></div>

<?php endif; ?>

<?php unset($_SESSION['res']); ?>

</body>

</html>
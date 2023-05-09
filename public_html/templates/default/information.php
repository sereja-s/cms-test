<?php if (!empty($this->menu['information'])) : ?>

	<div class="container">

		<?= $this->breadcrumbs ?>

		<h1 class="page-title h1"><?= $this->menu['information'][0]['name'] ?></h1>
	</div>

	<section class="catalog-internal">
		<div class="container">


			<?= $this->menu['information'][0]['content'] ?>


		</div>
	</section>

<?php endif; ?>
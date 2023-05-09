$(function () {
	//------------------- Swipers -------------------//
	var mainSlider = new Swiper('.slider__container', {
		pagination: {
			el: '.slider__pagination',
			type: 'fraction',
		},
		navigation: {
			nextEl: '.slider__controls._next',
			prevEl: '.slider__controls._prev',
		},
		loop: true,
		// Автопрокрутка
		autoplay: {
			/* пауза между прокруткой */
			delay: 10000,
			/* закончить на последнем слайде */
			//stopOnLastSlide: true,
			/* отключить после ручного переключения */
			//disableOnInteraction: false,
		},
		// скорость
		speed: 5000
	});

	var partnersSlider = new Swiper('.partners__container', {
		navigation: {
			nextEl: '.partners__controls._next',
			prevEl: '.partners__controls._prev',
		},
		slidesPerView: 1,
		spaceBetween: 20,
		loop: true,
		breakpoints: {
			1601: {
				slidesPerView: 8
			},
			1367: {
				slidesPerView: 7
			},
			1281: {
				slidesPerView: 6
			},
			1025: {
				slidesPerView: 5
			},
			769: {
				slidesPerView: 4
			},
			561: {
				slidesPerView: 3
			},
			421: {
				slidesPerView: 2
			},
		}
	});

	var indexOffersSlider = null;

	var indexOffersSliderOptions = {
		navigation: {
			nextEl: '.offers__controls._next',
			prevEl: '.offers__controls._prev',
		},
		slidesPerView: 1,
		spaceBetween: 20,
		wrapperClass: 'offers__tabs_wrapper',
		slideClass: 'offers__tabs_card',
		watchOverflow: true,

		breakpoints: {
			1251: {
				slidesPerView: 4,
			},
			769: {
				slidesPerView: 3
			},
			561: {
				slidesPerView: 2
			}
		}
	};
	indexOffersSlider = new Swiper('.offers__tabs_container', indexOffersSliderOptions);
	new Swiper('.active .offers__tabs_container', indexOffersSliderOptions);


	//------------------- Tabs Mainpage -------------------//
	$('ul.offers__tabs_header').on('click', 'li:not(.active)', function () {
		$(this)
			.addClass('active').siblings().removeClass('active')
			.closest('div.offers__tabs').find('div.offers__tabs_content').removeClass('active').eq($(this).index()).addClass('active');
		var index = $(this).index();
		indexOffersSlider[index].slideTo(0);
		indexOffersSlider[index].update();

	});
	//------------------- Burger Sidebar  -------------------//
	$('.burger-menu').on('click', function () {
		var burgerHidden = $('.header__menu').hasClass('_hidden');
		var callbackHidden = $('.header__callback').hasClass('_hidden');
		if (burgerHidden) {//бургер скрыт
			if (!callbackHidden) {//но открыта обратка
				$('.header__callback').addClass('_hidden');//скроем обратку
				if ($(window).width() <= 1024) {//на мобилке
					$('.overlay').removeClass('_visible');
					$('.header__sidebar').removeClass('_bg-opened');
				}
			}
			else {//обратка закрыта
				$('.overlay').addClass('_visible');//покажем оверлей тк его нет
				if ($(window).width() <= 1024) {
					$('.header__sidebar').addClass('_bg-opened')//на бургере повернем крестик
					$('.header__menu').removeClass('_hidden');
				}
			}
			if ($(window).width() > 1024) {
				$('.header__menu').removeClass('_hidden');//в любом случае вызовем меню на десктопе
			}
		}
		else {//бургер открыт
			$('.overlay').removeClass('_visible');//скроем оверлей
			if ($(window).width() <= 1024) {
				$('.header__sidebar').removeClass('_bg-opened')//свернем крестик в бургер
			}
			$('.header__menu').addClass('_hidden');//скроем меню
		}
	});
	$('.header__menu_close').on('click', function () {
		$('.overlay').removeClass('_visible');
		if ($(window).width() <= 1024) {
			$('.header__sidebar').removeClass('_bg-opened')
		}
		$('.header__menu').addClass('_hidden');
	});
	//------------------- Callback Popup  -------------------//
	$('.js-callback').on('click', function () {
		$('.overlay').addClass('_visible');
		if ($(window).width() <= 1024) {
			$('.header__sidebar').addClass('_bg-opened')
		}
		$('.header__callback').removeClass('_hidden');
	});
	$('.header__callback_close').on('click', function () {
		$('.overlay').removeClass('_visible');
		if ($(window).width() <= 1024) {
			$('.header__sidebar').removeClass('_bg-opened')
		}
		$('.header__callback').addClass('_hidden');
	});
	//------------------- Overlay Events  -------------------//
	$('.overlay').on('click', function () {
		var burgerHidden = $('.header__menu').hasClass('_hidden');
		var callbackHidden = $('.header__callback').hasClass('_hidden');

		if (!burgerHidden) {
			$('.header__menu').addClass('_hidden');
		}
		if (!callbackHidden) {
			$('.header__callback').addClass('_hidden');
		}

		$('.overlay').removeClass('_visible');
		if ($(window).width() <= 1024) {
			$('.header__sidebar').removeClass('_bg-opened')
		}
	});
	//------------------- Masked Inputs  -------------------//
	$('.js-mask-phone').mask("+7 (999) 999-99-99");

	//------------------- Horizontal Scroll -------------------//
	var controller = new ScrollMagic.Controller();

	if ($(window).width() > 1024) {
		var timeline = new TimelineMax();
		timeline
			.to($('.horizontal__wrapper'), 1, { xPercent: '-50' });

		var horizontalScroll = new ScrollMagic.Scene({
			triggerElement: '.horizontal',
			triggerHook: 'onEnter',
			offset: $('.horizontal__wrapper').height(),
			duration: '100%'
		})
			.setTween(timeline)
			.setPin(".horizontal__wrapper")
			.addTo(controller);
	}



	//------------------- Sticky Search -------------------//
	if ($(window).width() > 1024 && $('.news').length > 0) {
		var heightToFooter = $('.news').offset().top;

		var stickySearch = new ScrollMagic.Scene({
			triggerElement: '.footer',
			triggerHook: 'onEnter'
		})
			.setClassToggle('.search', '_unpin')
			.addTo(controller);
	}
	//------------------- Add Desktop Animate Classes -------------------//
	if ($(window).width() > 1024) {
		$('.search').addClass(['animated', 'bounceInLeft']);
		$('.header__sidebar').addClass(['animated', 'bounceInUp']);
	}


	//=============== Обработчик кнопи выбора количества отображаемых товаров каталога (Выпуск №134) ===================//

	$('.qty-items a').on('click', function (e) {

		e.preventDefault();


		let qty = +$(this).text()


		if (qty && !isNaN(qty)) {

			$(this).closest('.catalog-section-top-items__toggle').children('span').html(qty)

			$.ajax({

				url: '/',

				data: {

					qty: qty,

					ajax: 'catalog_quantities'

				}
			})

			// после выбора кол-ва отображаемых товаров на странице каталога, запустим перезагрузку страницы (+Выпуск №136)
			setTimeout(() => {

				location.href = location.pathname

			}, 100)

		}

	})

});


//=================================== кнопка ПОКАЗАТЬ ВСЁ (в карточке товара) Выпуск №138 ===========================//

document.addEventListener('DOMContentLoaded', () => {

	let moreBtn = document.querySelector('.card-main-info__description .more-button')

	if (moreBtn) {

		moreBtn.addEventListener('click', e => {

			e.preventDefault()

			// блок характеристик товаров откроется при плавном скролле к нему
			document.querySelectorAll('.card-tabs__toggle.tabs__toggle')[1].dispatchEvent(new Event('click'))

			// плавный скролл к блоку характеристик товара при щелчке на кнопке ПОКАЗАТЬ ВСЁ
			window.scrollTo({
				top: document.querySelector('.card-tabs').getBoundingClientRect().top + scrollY,
				behavior: 'smooth'
			})

		})

	}

	//---------------- перемещение слайдра при клике на картинке галереи в карточке товара (Выпуск №138) --------------//

	/* (function () {

		let start = 0

		document.querySelectorAll('.card-main-gallery-thumb__slide').forEach(item => {

			item.addEventListener('click', () => {

				// получим координаты: 

				let itemCoords = item.getBoundingClientRect()

				let parentCoords = item.parentElement.parentElement.getBoundingClientRect()

				// уравняем их относительно скролла экрана

				let itemY = scrollY + itemCoords.y

				let parentY = scrollY + parentCoords.y

				// получим свойство элементов (картинок слайдера): marginBottom
				let margin = parseFloat(getComputedStyle(item)['marginBottom'])

				// получим размер на который смещаться: height + marginBottom
				let top = Math.ceil(itemCoords.height + margin)

				// что бы кликать вниз надо получить исходное значение смещения Y между родителем и текущим элементом

				if (item.nextElementSibling && Math.ceil(itemY - parentY + top) >= parentCoords.height) {

					start -= top

				} else if (item.previousElementSibling && itemY <= parentY) {

					start += top

				}

				// смещаем контейнер слайдера галереи

				item.parentElement.style.transition = '0.3s'

				item.parentElement.style.transform = `translate3d(0px, ${start}px, 0px)`

			})

		})

	})() */

	addToCart()

	changeQty()

	/* ========================== открывается order-popup для оформлении заказа (выпуск №144-145)====================== */

	document.querySelectorAll('[data-popup]').forEach(item => {

		// если не пустой атрибут
		if (item.getAttribute('data-popup')) {

			let popupElement = document.querySelector(`.${item.getAttribute('data-popup')}`);

			if (popupElement) {

				item.addEventListener('click', () => {

					popupElement.classList.add('open')
				});

				popupElement.addEventListener('click', e => {

					// если кликнули по текущему элементу (а не по внутреннему)
					if (e.target === popupElement) {

						popupElement.classList.remove('open')
					}

				});

			}
		}
	})

})


//=========================================== кнопка: в корзину (Выпуск №139) =======================================//

function addToCart() {

	document.querySelectorAll('[data-addToCart]').forEach(item => {

		item.addEventListener('click', e => {

			e.preventDefault()

			// получим идентификатор товара

			let cart = {}

			cart.id = +item.getAttribute('data-addToCart')

			if (cart.id && !isNaN(cart.id)) {

				let productContainer = item.closest('[data-productContainer]') || document

				cart.qty = null

				let qtyBlock = productContainer.querySelector('[data-quantity]')

				if (qtyBlock) {

					cart.qty = +qtyBlock.innerHTML || 1
				}

				cart.ajax = 'add_to_cart'

				$.ajax({

					url: '/',
					data: cart,
					error: res => {

						console.error(res)
					},

					success: res => {

						//console.log(res)

						// Выпуск №141
						try {

							res = JSON.parse(res)

							//console.log(res)

							if (typeof res.current === 'undefined') {

								throw new Error('')
							}

							item.setAttribute('data-toCartAdded', true);

							['data-totalQty', 'data-totalSum', 'data-totalOldSum'].forEach(attr => {

								let cartAttr = attr.replace(/data-/, '').replace(/([^A-Z])([A-Z])/g, '$1_$2').toLowerCase()

								//console.log(cartAttr)

								document.querySelectorAll(`[${attr}]`).forEach(el => {

									if (typeof res[cartAttr] !== 'undefined') {

										//console.log(cartAttr)
										//console.log(res[cartAttr])
										//console.log('total_qty')

										//el.innerHTML = res[cartAttr] + ' руб.'

										//el.innerHTML = res[cartAttr] + (cartAttr !== 'total_qty' ? ' руб.' : '')

										// Выпуск №144
										el.innerHTML = res[cartAttr] + (attr === 'data-totalQty' ? '' : ' руб.');

									}

								})
							})

						} catch (e) {

							alert('Ошибка добавления в корзину')
						}
					}
				})
			}

		})

	})
}

//=================================== кнопки: + и - в карточке товара (Выпуск №139) ==================================//

function changeQty() {

	let qtyButtons = document.querySelectorAll('[data-quantityPlus], [data-quantityMinus]')

	qtyButtons.forEach(item => {

		item.addEventListener('click', e => {

			e.preventDefault()

			let productContainer = item.closest('[data-productContainer]') || document

			//let inCart = false;

			let qtyEl = productContainer.querySelector('[data-quantity]')

			if (qtyEl) {

				let qty = +qtyEl.innerHTML || 1

				//console.log(qty)

				if (item.hasAttribute('data-quantityPlus')) {

					qty++
				} else {

					qty = qty <= 1 ? 1 : --qty
				}

				qtyEl.innerHTML = qty

				let addToCart = productContainer.querySelector('[data-addToCart]')

				if (addToCart) {

					if (addToCart && addToCart.hasAttribute('data-toCartAdded')) {

						addToCart.dispatchEvent(new Event('click'))
					}
				}
			}
		})
	})
}

//------------------------------------ валидатор номера телефона (Выпуск №146) ---------------------------------------//

document.querySelectorAll('input[type="tel"]').forEach(item => phoneValidate(item));

function phoneValidate(item) {

	let countriesOptions = {

		// +7(495)111-22-33
		'+7': {

			// укажем лимит символов в строке телефона в форме
			limit: 16,
			// укажем св-во, в котором сохраним первые цифры для которых будет осуществляться подмена
			firstDigits: '87',
			// св-во при помощи которого будет осуществляться форматирование телефона (здесь- это объект, в котором мы 
			// будем хранить порядковые номера символов, после которых будем что то вствлть(заменять и т.д.))
			formatChars: {

				2: '(',
				6: ')',
				10: '-',
				13: '-',
			}
		},

		// например добавим форматирование для другой страны: +994(123)456-78-99
		'+994': {

			// укажем лимит символов в строке телефона в форме
			limit: 18,
			// св-во при помощи которого будет осуществляться форматирование телефона (здесь- это объект, в котором мы 
			// будем хранить порядковые номера символов, после которых будем что то вствлть(заменять и т.д.))
			formatChars: {

				4: '(',
				8: ')',
				12: '-',
				15: '-',
			}
		}
	};

	item.addEventListener('input', e => {

		if (e.inputType === 'deleteContentBackward' || e.inputType === 'deleteContentForward') {

			// не мешаем пользователю ничего удалить
			return false
		};

		// чистим от не цифр, всё что пользователь вводит в поле тел.номера формы
		item.value = item.value.replace(/\D/g, '');

		if (item.value) {

			// сформируем корректные ключи (по стране)
			for (let code in countriesOptions) {

				if (countriesOptions.hasOwnProperty(code) && countriesOptions[code].firstDigits) {

					let regExp = new RegExp(`^[${countriesOptions[code].firstDigits}]`);

					if (regExp.test(item.value)) {

						// заменяем value на code (здесь- код страны: +7)
						item.value = item.value.replace(regExp, code);
						break;
					}
				}
			}

			// если символа: + нет, его надо подставить
			if (!/^\+/.test(item.value)) {

				item.value = '+' + item.value;
			}

			// снова запустим цикл:
			// сформируем корректные ключи (по стране)
			for (let code in countriesOptions) {

				if (countriesOptions.hasOwnProperty(code)/*  && countriesOptions[code].firstDigits */) {

					let regExp = new RegExp(code.replace(/\+/g, '\\+'), 'g');

					if (regExp.test(item.value)) {

						for (let i in countriesOptions[code].formatChars) {

							// приведём к xислу строковую переменную i
							let j = +i;

							if (item.value[j] && item.value[j] !== countriesOptions[code].formatChars[i]) {

								item.value = item.value.substring(0, j) + countriesOptions[code].formatChars[i] + item.value.substring(j)
							}
						}

						// ограничим данные
						if (item.value[countriesOptions[code].limit]) {

							item.value = item.value.substring(0, countriesOptions[code].limit);
						}
					}
				}
			}
		}
	});

	// для корректной работы при перезагрузке страницы
	item.dispatchEvent(new Event('input'));

	// если после ввода телефонного номера пользователь попытается изменить формат записи на неправильный, номер 
	// автоматически будет исправлен на корректный
	item.addEventListener('change', () => phoneValidate(item));

}

//================================== поиск по каталогу ================================================================//
menuSearch();

function menuSearch() {

	// Для кнопки поиска в админке (с id = "searchButton") - div внутри которого расположен другой div с изображением поиска):
	let searchBtn = document.querySelector('#searchButton');

	// для полученного в переменную div с id = "searchButtonCat" найдём input type="search"
	let searchInput = searchBtn.querySelector('input[type=search]');

	// на searchBtnCat вешаем событие: click
	searchBtn.addEventListener('click', () => {

		// что бы блок поиска появился, добавим класс: vg-search-reverse при клике
		searchBtn.classList.add('vg-search-reverse');

		// поставим курсор на поле ввода (фокус)
		searchInput.focus();
	});

	// организуем закрытие поиска при потере фокуса (щелчке на другом месте, переключении вкладок): вешаем событие: blur
	searchInput.addEventListener('blur', e => {

		// организуем в поиске переход по подсказке (ссылке) при нажатии на неё (Выпуск №113)
		if (e.relatedTarget && e.relatedTarget.tagName === 'A') {

			return
		}

		// удалим класс: vg-search-reverse (поле поиска закроется)
		searchBtn.classList.remove('vg-search-reverse');
	});

}


// в переменную сохраним самовызывающуюся функцию, внутри которой будет реализовано замыкание (для работы с
// появляющимися подсказками при вводе строки в поле поиска) Вызывается сразу после кода
// (эта функция будет возвращать другую функцию, которую мы и будем вызывать по обращению к имени: searchResultHover)
let searchResultHover = (() => {

	// Инициализируем ряд переменных Эти переменные инициализируются один раз (при первом обращении к ф-ии в переменной:
	// searchResultHover) и затем будут замкнуты в участке кода до: return () => {} и фактически выполнятся только один раз 
	// Каждый раз, когда мы будем повторно вызывать: searchResultHover(), будет вызывться функция которая вернулась т.е.
	// return() => { }, а переменные описанные выше неё останутся нетронутыми(т.е.замкнутыми) и будет выполняться (исходя 
	// из нового вызова) участок кода описанный внутри: return () => { }:

	// найдём и сохраним элемент с классом внутри которого будет выпадающее меню с ссылками-подсказками для поиска
	let searchRes = document.querySelector('.search_res')

	// аналогично найдём input с type = text (также можно было бы работать и с name="search"), содержащийся в блоке
	// поиска (с id="searchButton")
	let searchInput = document.querySelector('#searchButton input[name=search]')

	// объявим переменную- дефолтное значение для Input поиска
	let defaultInputValue = null

	/**
	 * Метод, который будет обрабатывать нажатие стрелочек (вниз-вверх) в подсказках при поиске (Выпуск №100)
	 * (на вход: e- объект события)
	 */
	function searchKeyDown(e) {

		// если элемент с id = searchButton не содержит класса: vg-search-reverse (т.е. не активен) или не нажата кнопка:
		// стрелка-вверх и не нажата кнопка: стрелка-вниз (в объекте: е- событие, есть свойство: key, которое и показывает какую кнопку нажали)
		if (!(document.querySelector('#searchButton').classList.contains('vg-search-reverse')) ||
			(e.key !== 'ArrowUp' && e.key !== 'ArrowDown')) {

			// завершаем работу скрипта
			return;
		}

		// сделаем деструктивное присваивание (приведём к массиву) для содержимого в searchRes.children
		let children = [...searchRes.children];

		if (children.length) {

			// скинем действия по умолчанию (чтобы курсор не перескакивал на начало слова в строке поиска, при нажатии на кнопки: вверх (вниз))
			e.preventDefault();

			// получим активный элемент (выделенная ссылка в выпадающем меню подсказок при поиске)
			// если querySelector() ничего не найдёт, то по умолчанию вернёт: null 
			let activeItem = searchRes.querySelector('.search_act')

			// сформируем переменную по условию и получим индекс элемента, который лежит в activeItem, иначе: -1
			let activeIndex = activeItem ? children.indexOf(activeItem) : -1

			// если нажата кнопка: стрелка-вниз
			if (e.key === 'ArrowUp') {

				// сформируем переменную по условию
				// здесь (children.length - 1) означает последний элемент массива
				activeIndex = activeIndex <= 0 ? children.length - 1 : --activeIndex

				// если не нажата
			} else {

				// сформируем переменную по другому условию
				activeIndex = activeIndex === children.length - 1 ? 0 : ++activeIndex
			}

			// у всех элементов: children необходимо убрать класс: search_act (если он есть)
			children.forEach(item => item.classList.remove('search_act'))

			// обратимся к массиву в переменной: children (его ячейке: [activeIndex])  и добавим класс: search_act
			children[activeIndex].classList.add('search_act')

			// +Выпуск №113
			// в элемент: searchInput (в его значение: value) занесём значение: innerText из children[activeIndex]
			searchInput.value = children[activeIndex].innerText.replace(/\s*\(.+?\)\s*$/, '');
		}
	}

	/**
	 * Метод установки значения по умолчанию: для input в переменной: searchInput (в строке поиска)
	 */
	function setDefaultValue() {

		// в переменную: searchInput (в его переменную: value) положим значение переменной: defaultInputValue
		searchInput.value = defaultInputValue
	}

	// Опишем 2-а слушателя событий:
	// (На вход: 1- событие, 2- функция, должна быть вызвана только тогда, когда на элементе сработает обработчик событий 
	// (для этого передаём её в качестве параметра без круглых скобок))
	// Иначе (с круглыми скобками) ф-я была бы вызвана до обработчика событий

	// Событие: mouseleave срабатывает, когда курсор манипулятора (обычно мыши) перемещается за границы элемента
	searchRes.addEventListener('mouseleave', setDefaultValue)

	// Событие: keydown срабатывает, когда клавиша была нажата
	window.addEventListener('keydown', searchKeyDown)

	// вернется самовызывающая функция (будет вызываться в качестве результата при каждом обращении к 
	// переменной: searchResultHover (к ф-и в ней))
	return () => {

		//setTimeout(() => {

		// в переменую положим значение searchInput (его поля)
		defaultInputValue = searchInput.value;


		// если подсказки(ссылки) существуют в переменной: searchRes (его св-ве: children, его св-ве: length)
		if (searchRes.children.length) {

			//  свойство children объекта возвращает живую коллекцию (HTMLCollection), которая постонно отслеживается
			// (т.к. ссылки здесь будут постоянно меняться) и которая содержит все дочерние элементы узла, на котором оно было вызвано

			// используем деструктивное присваивание (преобразуем значение из searchRes.children в массив указав слева три 
			// точки) и сохраним в переменной: children
			// (Деструктивное присваивание - упрощает извлечение данных из массивов и объектов, при помощи более короткого синтаксиса)
			let children = [...searchRes.children]

			children.forEach(item => {

				// на текущий элемент: item, вешаем обработчик события на событие: mouseover (наведение указателя мыши)
				item.addEventListener('mouseover', () => {

					// уберём у children класс который подсвечивает подсказки (ссылки)
					children.forEach(el => el.classList.remove('search_act'))

					// для текущего элемента: item добавим класс
					item.classList.add('search_act')

					// то что лежит в св-ве innerText (для элемента: item) положим в элемент: searchInput, в его св-во: value
					// (т.е. в поле поиска попадёт название той ссылки, на которую попадёт указатель мыши)
					searchInput.value = item.innerText
				})
			})
		}

		//}, 5000);

	}

})()
// самовызывающуюся функцию необходимо вызывать сразу после того как её код описан
searchResultHover()

/**
 * Метод работы поиска в админке (вывод подсказок(ссылок)) Выпуск №105
 */
function search() {

	let searchInput = document.querySelector('input[name=search]');

	//console.log(searchInput);

	if (searchInput) {

		// (событие oninput происходит сразу после изменения значения элемента)
		//searchInput.oninput = () => {

		// search - событие возникает после того как пользователь нажимает на клавишу Enter или нажимает кнопку "x" (отмена) в элементе input с type="search"
		searchInput.addEventListener('search', () => {

			// сделаем ограничение (подсказки(ссылки) появятся при вводе более одного символа в поисковой строке)
			if (searchInput.value.length > 1) {

				$.ajax({
					url: '/',
					// в Ajax нам нужен объект: data
					data: {
						// в котором будет три поля (свойства)
						data: searchInput.value, // в поле: data отправляем: searchInput.value
						table: document.querySelector('input[name="search_table"]').value, // ищем с приоритетом по категориям (получим соответствующее поле)
						ajax: 'search' // управляющий флаг (для Ajax-контроллера)
					},
					success: res => {

						//console.log(res);

						try {

							res = JSON.parse(res);

							let resBlok = document.querySelector('.search_res');

							let counter = res.length > 20 ? 20 : res.length;

							if (resBlok) {

								resBlok.innerHTML = '';

								for (let i = 0; i < counter; i++) {

									// на вход: 1- параметр: вставляем в конец, 2-ой: что вставляем
									resBlok.insertAdjacentHTML('beforeend', `<a href="${res[i]['alias']}">${res[i]['name']}</a>`);
								}
								// снова вызовем метод (т.к. там будут все неоходимые элементы)
								searchResultHover();
							}

						} catch (e) {

							alert('Ничего не найдено по вашему запросу')
						}
					}
				})


			} else {
				alert("введите больше одного символа")
			}

		});

		//}
	}
}

search();

//========================================== стрелка-вверх ========================================================//

// sctroll to top
var arrowTop = document.getElementById("arrowTop");

//console.log(arrowTop)

arrowTop.onclick = function () {
	window.scrollTo(pageXOffset, 0);
};

// после scrollTo возникнет событие "scroll", так что стрелка автоматически скроется
window.addEventListener('scroll', function () {
	arrowTop.hidden = (pageYOffset < document.documentElement.clientHeight);
});


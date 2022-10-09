//console.log(PATH);

// опишем объект, который будет отвечать за отправку асинхронных запросов (Выпуск №68)
//  и объявим стрелочную ф-ию, в которую будет приходить объект настроек: set
// (в стрелочной ф-ии не доступен указатель на контекст(ключевое слово: this), т.е. указатель на объект (this будет искать ближайший контекст, который ему доступен (здесь- это объект: Window)))
/**
 * Объект, который будет отвечать за отправку асинхронных запросов 
 */
const Ajax = (set) => {

	//console.log(this);

	if (typeof set === 'undefined') set = {};

	if (typeof set.url === 'undefined' || !set.url) {

		set.url = typeof PATH !== 'undefined' ? PATH : '/';
	}

	// +Выпуск №95
	if (typeof set.ajax === 'undefined') {

		set.ajax = true;
	}

	if (typeof set.type === 'undefined' || !set.type) set.type = 'GET';

	set.type = set.type.toUpperCase();

	let body = '';

	if (typeof set.data !== 'undefined' && set.data) {

		// +Выпуск №95
		if (typeof set.processData !== 'undefined' && !set.processData) {

			body = set.data;

		} else {

			for (let i in set.data) {

				if (set.data.hasOwnProperty(i)) {

					body += '&' + i + '=' + set.data[i];
				}
			}

			body = body.substr(1);

			if (typeof ADMIN_MODE !== 'undefined') {

				body += body ? '&' : '';

				body += 'ADMIN_MODE=' + ADMIN_MODE;
			}
		}

	}

	if (set.type === 'GET') {

		set.url += '?' + body;
		body = null;
	}

	return new Promise((resolve, reject) => {

		let xhr = new XMLHttpRequest();

		// откроем соединение
		xhr.open(set.type, set.url, true);

		// сделаем базовые настройки соединения
		let contentType = false;

		if (typeof set.headers !== 'undefined' && set.headers) {

			for (let i in set.headers) {

				//+Выпуск №95
				if (set.headers.hasOwnProperty(i)) {

					// установим заголовки для объекта: XMLHttpRequest
					xhr.setRequestHeader(i, set.headers[i]);

					if (i.toLowerCase() === 'content-type') contentType = true;
				}

			}
		}

		// +выпуск №95
		if (!contentType && (typeof set.contentType === 'undefined' || set.contentType))
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

		// +выпуск №95
		if (set.ajax)
			// сформируем заголовок
			xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

		xhr.onload = function () {

			if (this.status >= 200 && this.status < 300) {

				if (/fatal\s+?error/ui.test(this.response)) {

					reject(this.response);
				}

				resolve(this.response);
			}

			reject(this.response);
		}

		xhr.onerror = function () {

			reject(this.response);
		}

		// отправим данные на сервер
		xhr.send(body);

	});

}


/** Метод проверит не пуст ли массив */
function isEmpty(arr) {

	// если цикл начнёт выполняться, значит массив не пуст
	for (let i in arr) {

		// то вернём:
		return false;
	}

	// иначе:
	return true;
}


/**
 *   Метод вывода сообщения об ошибке (Выпуск №96)
 */
function errorAlert() {

	alert('Произошла внутренняя ошибка');

	return false;
}


/**
 * Свойство: slideToggle в котором хранится функция для реализации аккордеона (Выпуск №97)
 *  (На вход: 1- время анимации, 2- параметр: callback (сообщение появляется при клике на элементе после срабатывания))
 */
Element.prototype.slideToggle = function (time, callback) {

	let _time = typeof time === 'number' ? time : 400;
	callback = typeof time === 'function' ? time : callback;

	// Функция getComputedStyle (у объекта: window) позволяет получить значение любого CSS свойства элемента, даже из CSS файла
	if (getComputedStyle(this)['display'] === 'none') {

		// то элемент надо открыть:

		// 1- его св-во: transition поставим в null
		this.style.transition = null;

		// 2- его св-во: overflow поставим в значение: hidden
		this.style.overflow = 'hidden';

		// 3- его св-во: maxHeight поставим в значение: ноль
		this.style.maxHeight = 0;

		// 4- его св-во: display поставим в значение: block (т.е. теперь можем показать элемент)
		this.style.display = 'block';

		//console.log(this);
		//console.dir(this);

		// аналогично установим значения (и конкатенируем к ним единицы измерения) следующих свойств:

		this.style.transition = _time + 'ms';

		this.style.maxHeight = this.scrollHeight + 'px';

		// вызовем функцию: setTimeout
		setTimeout(() => {

			callback && callback();
		}, _time); // укажем промежуток времени (на выполнение анимации)

		// иначе если элемент был открыт закроем его (свернём раскрывающийся список)
	} else {

		this.style.transition = _time + 'ms';

		this.style.maxHeight = 0;

		setTimeout(() => {

			this.style.transition = null;

			this.style.display = 'none'; // скроем элемент

			callback && callback();
		}, _time);
	}
}


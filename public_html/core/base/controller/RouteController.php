<?php

namespace core\base\controller;

use core\base\exceptions\RouteException;
use core\base\settings\Settings;


/** 
 * Точка входа в нашу систему контроллеров (отвечает за разбор адресной строки)
 * Методы: private function __construct(); private function createRoute($var, $arr)
 */
class RouteController extends BaseController
{

	use Singleton;

	// свойство маршруты
	protected $routes;

	/**
	 * Конструктор класса (вызывается при создании объекта класса)
	 */
	private function __construct()
	{
		// получим адресную строку (сохраняем ячейку 'REQUEST_URI' суперглобального массива СЕРВЕР)
		// в этой ячейке хранится: / и весь дальнеший адрес
		$adress_str = $_SERVER['REQUEST_URI'];

		// если в суперглобальном массиве: $_SERVER и его ячейке: QUERY_STRING что-нибудь есть (не пустая)
		/* if ($_SERVER['QUERY_STRING']) {
			// обрезаем строку: $adress_str с нулевого элемента по (находим первое вхождение в строке (в $adress_str) подстроки (в // $_SERVER['QUERY_STRING']) элемент, минус 1 элемент (знак- ?) и результат сохраняем в переменной: $adress_str
			$adress_str = substr($adress_str, 0, strpos($adress_str, $_SERVER['QUERY_STRING']) - 1);
		} */

		// В переменную $path сохраним обрезанную строку (без знака /), в которой содержится имя выполнения скрипта
		// (в ячейке PHP_SELF глобального массива $_SERVER)

		// функция php: substr() возвращает подстроку строки Здесь-  $_SERVER['PHP_SELF'], начинающейся с (здесь- 0) символа по счету и длиной strrpos($_SERVER['PHP_SELF'], 'index.php') символов.
		// (здесь- функция php: strrpos() Возвращает номер позиции последнего вхождения index.php относительно начала строки $_SERVER['PHP_SELF'])
		$path = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], 'index.php'));

		// условие: если переменная $path равна константе PATH (описана в файле: config.php)
		if ($path === PATH) {

			// сделаем проверку: есть ли в конце адресной строки знак / 
			// при этом знак / сразу после домена необходим (ставится системой автоматически и указыввает на корень сайта) 
			/* if (
				// функция php: strrpos() ищет последнее вхождение подстроки (здесь- /) в строке (здесь- $adress_str) и возвращает номер позиции
				// функция php: strlen() показвает длину строки (массива символов (здесь- $adress_str)) 
				// т.к. у массива нумерация начинается с 0, а длина строки меряется с 1, учтём это и запишем -1 
				strrpos($adress_str, '/') === strlen($adress_str) - 1 &&
				// если выполнится первое условие, мы должны знать, что это не корень сайта (там знак / стоит всегда по умолчанию)
				// последнее вхождение  символа / не должно быть равно длине строки: PATH - 1
				strrpos($adress_str, '/') !== strlen(PATH) - 1
			) {
				// Направим пользователя на страницу по ссылке без этого символа (/) с помощью функции php: redirect()
				// 1-ым параметром будет функция php: rtrim(), которая обрезает концевые пробелы в начале и конце строки, 
				// а также символы в конце строки, которые указаны в качестве второго не обязательного параметра на входе (здесь- /)
				// 2-ым параметром функции php: redirect() укажем: 301- код ответа сервера (будет отправлен браузеру)
				$this->redirect(rtrim($adress_str, '/'), 301);
			} */

			// в свойстве routes сохраним маршруты (обратились к классу Settings и его статическому методу get())
			$this->routes = Settings::get('routes');

			// проверка : описаны ли маршруты (если нет- получим сообщение)
			if (!$this->routes) {
				throw new RouteException('Отсутствуют маршруты в базовых настройках', 1);
			}

			// создаём переменную в которой преобразуем в массив адресную строку и разбираем по разделителю (здесь- /)
			// функция php: explode()- перобразует строку (2-ой параметр) в массив по заданному разделителю (1-ый параметр)
			// у нас адресная строка будет возвращена, сразу начиная 1-го символа, после знака / функцией substr() и только затем преобазована
			// т.е. в переменную $url попадает полный маршрут
			/* $url = explode('/', substr($adress_str, strlen(PATH))); */



			$url = preg_split('/(\/)|(\?.*)/', $adress_str, 0, PREG_SPLIT_NO_EMPTY);


			// проверим не в админку ли хочет попасть пользователь
			// если запрос в админку
			// если в нулевой ячейки массива $url что-нибудь есть и строго равно указанному маршруту
			// (чтобы в админку можно было попасть только по указанному у нас маршруту (здесь- admin))
			if ($url[0] && $url[0] === $this->routes['admin']['alias']) {
				// тогда начинаем работать внутри административной панели:
				// функция php: array_shift() Извлекает первое значение массива array и возвращает его, 
				// сокращая размер массива (здесь- $url) на один элемент
				array_shift($url);


				// Проверим: не лежит ли в нулевом элементе массива (адресной строки) обращение к плагину
				// и существует ли директория (папка) для плагина (функция php: is_dir())

				// на вход ф-ии is_dir() подаётся полный путь к директории (здесь- DOCUMENT_ROOT- ячейка суперглобального массива $_SERVER и является корневой папкой проекта)
				// далее обращаемся к константе PATH (корень нашего сайта) 
				// далее указываем путь к директории в которой лежат плагины: $this->routes['plugins']['path']
				// далее надо узнать: есть ли директория с плагином $url[0] (конкатенируем имя плагина т.е. $url[0])
				if ($url[0] && is_dir($_SERVER['DOCUMENT_ROOT'] . PATH . $this->routes['plugins']['path'] . $url[0])) {

					// определим переменную $plugin сохраним результат работы ф-ии php: array_shift(), которая
					// извлечёт название плагина (первое значение массива $url)
					$plugin = array_shift($url);

					// обявим переменную $pluginSettings и в ней сформируем путь к файлам настроек для плагина и имя файла настроек
					// обращаемся к свойству $this->routes['settings']['path'] (его элементам (ячейкам))
					// затем добавляем имя плагина (предварительно сделав первую букву его названия заглавной) и к нему конкатенируем слово Settings
					$pluginSettings = $this->routes['settings']['path'] . ucfirst($plugin . 'Settings');

					// Проверка: существует ли такой файл (ф-ия file_exists())
					// на вход подаём полный путь к ффайлу настроек плагина
					if (file_exists($_SERVER['DOCUMENT_ROOT'] . PATH . $pluginSettings . '.php')) {
						// в переменную $pluginSettings сохраним имя, ссылающееся на класс (вместе с полным namespace)
						// произведём замену символа / в названии (пути) (ф-ия str_replace)
						// на вход подаём (что искать, на что заменять (предварителльно экранируя), где ищем)
						$pluginSettings = str_replace('/', '\\', $pluginSettings);

						//перезапишем свойство $this->routes 
						// (из переменной $pluginSettings мы вызываем данный класс и обращаемся к его статическому методу get()
						// передав на вход свойство которое хотим получить)
						$this->routes = $pluginSettings::get('routes');
					}

					// проверим наличие дополнительной (вложенной) директории (папки) плагина и сохраним в переменной $dir результат:
					// если директория существует, мы запишем в переменную $dir: / имя директории / ; иначе просто запишем /
					$dir = $this->routes['plugins']['dir'] ? '/' . $this->routes['plugins']['dir'] . '/' : '/';

					// сделаем дополнителльную защиту: если в написании пути будут: // , найдём их и заменим на /
					$dir = str_replace('//', '/', $dir);

					// досформеруем строку:
					// в свойство $this->controller помещаем свойство( его ячейки): $this->routes['plugins']['path']
					// далее конкатенируем переменную $plugin и переменную $dir (в которой будет директория или просто /)
					$this->controller = $this->routes['plugins']['path'] . $plugin . $dir;

					// определим для плагина переменную $hrUrl (false иои true)
					$hrUrl = $this->routes['plugins']['hrUrl'];

					// сформируем ячейку маршрута, чтобы мы могли работать с массивом настроек для плагинов
					$route = 'plugins';
				} else {
					// если к плагину обращения не было, значит мы попали в административную панель, то
					// в свойство $this->controller запишем путь к папке контроллеров административной панели
					$this->controller = $this->routes['admin']['path'];

					// проверим работаем ли мы с ЧПУ или нет (false иои true)
					$hrUrl = $this->routes['admin']['hrUrl'];

					// сформируем ячейку маршрута, чтобы мы могли работать с массивом настроек для админки
					$route = 'admin';
				}
			} else {

				// убедимся, что отправлен не Post-запрос (выпуск № 130 (отправка формы фильтров товара))
				if (!$this->isPost()) {

					$pattern = '';

					$replacement = '';

					if (END_SLASH) {

						if (!preg_match('/\/(\?|$)/', $adress_str)) {

							$pattern = '/(^.*?)(\?.*)?$/';

							$replacement = '$1/';
						}
					} else {

						if (preg_match('/\/(\?|$)/', $adress_str)) {

							$pattern = '/(^.*?)\/(\?.*)?$/';

							$replacement = '$1';
						}
					}

					if ($pattern) {

						$adress_str = preg_replace($pattern, $replacement, $adress_str);

						if (!empty($_SERVER['QUERY_STRING'])) {

							$adress_str .= '?' . $_SERVER['QUERY_STRING'];
						}

						$this->redirect($adress_str, 301);
					}
				}


				// В переменную сохраним то что находится в переменной $routes (ячейке user, в его ячейке hrUrl) 
				// (чтобы система понимала работать ей с ЧПУ или нет)
				$hrUrl = $this->routes['user']['hrUrl'];

				// определим откуда подключать контроллер (здесь укажем базовый маршрут)
				$this->controller = $this->routes['user']['path'];

				// укажем для кого создаём маршрут
				$route = 'user';
			}

			// вызовем метод, который будет создавать маршрут Передаём: 1- маршрут который надо создать (описание) и 
			// 2- массив из которого маршрут будет создан
			$this->createRoute($route, $url);


			// Сгенерируем свойство в котором будет храниться массив с параметрами:

			// В нулевом элементе массива $url[0] у нас хранится контроллер
			// Параметры будут храниться в массиве $url[1] начиная с первого элемента
			// сделаем проверку: есть ли у нас что-нибудь в первом элементе массива $url[1], значит у нас есть реализация этого массива
			if (!empty($url[1])) {
				// тогда объявим переменную $count и с помощью ф-ции php: count() посчитаем кол-во элементов массива $url
				$count = count($url);
				// объявим переменную $key в которой оставим пустую строку
				$key = '';

				// если работаем не с ЧПУ
				if (!$hrUrl) {
					// то в переменную $i занесём значение 1 (т.е. обход цикла начинаем с 1-го элемента массива)
					$i = 1;
				} else {
					// иначе обход цикла начинаем с 2-го элемента массива,
					// при этом 1-ый элемент мы сохраним в объявленном ранее свойстве parameters (в его ячейке массива ['alias'])
					$this->parameters['alias'] = $url[1];
					$i = 2;
				}

				// в цикле (в параметрах) мы не указали первый, так как от уже был объявлен (определён) выше ($i = 1; или $i = 2;)  // Он показывает с какого элемента начинать обход
				for (; $i < $count; $i++) {
					// если в ключе ничего нет (в начале он пуст и даст true)
					if (!$key) {
						// в переменную $key запишем $url[$i];
						$key = $url[$i];
						// создадим ячейку массива [$key] внутри свойства parameters и пока запишем пустую строку
						$this->parameters[$key] = '';
					} else {
						// иначе в свойство parameters (в ячейку массива [$key] в нём) запишем $url[$i];
						$this->parameters[$key] = $url[$i];
						// и обнулим ключ
						$key = '';
					}
				}
			}

			//exit();
		} else {
			throw new RouteException('Не корректная директория сайта', 1);
		}
	}

	// метод, который будет создавать маршрут	
	/** 
	 * Метод создаёт маршруты
	 * На вход: 1- $var- маршрут который надо создать (описание), $arr- массив ссылок из которого маршрут будет создан
	 */
	private function createRoute($var, $arr)
	{
		// определили массив явно (показывая, что у нас может быть этот массив)
		$route = [];

		// если не пуст нулевой элемент массива
		if (!empty($arr[0])) {

			// проверка: существует ли для ячейки $var алиас маршрутов
			// если существует, то подключить контроллеры и методы согласно алиаса маршрутов
			if (!empty($this->routes[$var]['routes'][$arr[0]])) {
				// разберём маршрут по разделителю /
				$route = explode('/', $this->routes[$var]['routes'][$arr[0]]);

				// к уже указанному выше базовому маршруту добавим название контроллера 
				// (предварительно преобразовав первую букву в заглавную с помощью ф-ции php: ucfirst() и там же добавив слово Controller)
				$this->controller .= ucfirst($route[0] . 'Controller');
			} else {
				//иначе
				// если не существует для ячейки $var алиас маршрутов
				$this->controller .= ucfirst($arr[0] . 'Controller');
			}
		} else {
			//иначе
			// если пуст нулевой элемент массива (запрашиается корень сайта), подключаем контроллер по умолчанию (здесь- IndexController)
			$this->controller .= $this->routes['default']['controller'];
		}

		// Определим какие подключатся методы 

		// условие: если у нас прописаны методы, необходмые для алиасов 
		// в файле Settings.php в массиве private $routes, в соответствующей ячейке маршрута 'routes' => [] (здесь этот массив объявлен как $route = [] ) т.е. если в нём что-то есть тогда они подключаются,
		// (при этом 1-я ячейка будет с входным методом, выходной метод будет занимать 2-ю ячейку)

		// иначе (если не прописаны такие методы в файле Settings.php), подключатся методы по умолчанию: inputMethod и outputMethod


		// $this->inputMethod = $route[1] ? $route[1] : $this->routes['default']['inputMethod'];
		$this->inputMethod = $route[1] ?? $this->routes['default']['inputMethod'];

		// $this->outputMethod = $route[2] ? $route[2] : $this->routes['default']['outputMethod'];
		$this->outputMethod = $route[2] ?? $this->routes['default']['outputMethod'];

		return;
	}
}

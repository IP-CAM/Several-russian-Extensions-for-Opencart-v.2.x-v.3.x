<?php
// Имя модуля, такой он будет виден на вкладке «модули» в панели управления и внутри настроек модуля
$_['heading_title']    = 'Бегущая строка';

// Text
$_['text_extension']    = 'Модули';
$_['text_success']      = 'Настройки модуля обновлены!';
$_['text_edit']        	= 'Редактирование модуля';
$_['text_text']        	= 'Бегущая строка';
$_['text_left']        	= 'с лева на право';
$_['text_right']       	= 'с право на лево';
$_['text_up']        	= 'с низу в верх';
$_['text_down']        	= 'с верху в низ';

// entry
$_['entry_name']       = 'Название модуля';
$_['entry_width']       = 'Ширина';
$_['entry_height']      = 'Высота';
$_['entry_status']      = 'Статус';
$_['entry_string']      = 'Введите строку:';
$_['entry_delayBeforeStart']   = 'Введите время:';
$_['entry_direction']   = 'Введите направление:';
$_['entry_duplicated']  = 'Зацикливание:';
$_['entry_duration']  = 'Продолжительность:';
$_['entry_speed']  = 'Время:';
$_['entry_gap']  = 'Растояние между разрывом:';
$_['entry_pauseOnHover']  = 'Остановить при наведении:';
$_['entry_pauseOnCycle']  = 'Остановить на:';
$_['entry_startVisible']  = 'Выделение:';
$_['entry_amount']  = 'Колличество обьектов:';
$_['entry_textColor']  = 'Цвет текста:';
$_['entry_textBg']  = 'Фон бегущей строки:';
$_['entry_fontSize']  = 'Размер шрифта (px):';
$_['entry_css']  = 'Дополнительные стили через ;';

// Error
$_['error_permission'] = 'У вас нет прав для управления этим модулем!';
$_['error_name']       = 'Название должно быть от 3 до 64 символа!';
$_['error_width']      = 'Необходимо указать ширину!';
$_['error_height']     = 'Необходимо указать высоту!';

// Help
$_['help_delayBeforeStart']     = '(Время в миллисекундах до начала анимации бегущей строки. Default: 1000)';
$_['help_direction']     = '(Направление, в котором будет анимироваться бегущая строка left/right/up/down. Default: left.)';
$_['help_duplicated']     = '(Направление, в котором будет анимироваться бегущая строка left/right/up/down. Default: left.)';
$_['help_duration']     = '(Продолжительность в миллисекундах, в течение которой вы хотите, чтобы ваш элемент перемещался. Default: 5000.)';
$_['help_speed']     = '(Скорость превалирует над продолжительностью. Скорость позволяет вам установить относительно постоянную скорость бегущей строки независимо от ширины содержащего элемента. Скорость измеряется в пикселях в секунду.)';
$_['help_gap']     = '(Зазор в пикселях между бегущими строками. Будет работать, только если для параметра дублирования установлено значение true. Default: 20. Примечание. 20 означает 20 пикселей, поэтому не нужно использовать «20 пикселей» в качестве значения.)';
$_['help_pauseOnHover']     = '(Приостановить бегущую строку при наведении. Если браузер поддерживает CSS3 и для параметра allowCss3Support установлено значение true, это будет сделано с использованием CSS3. В противном случае это будет сделано с помощью плагина jQuery Pause.. Default: false.)';
$_['help_pauseOnCycle']     = '(В цикле приостановите бегущую строку на миллисекунды.)';
$_['help_startVisible']     = '(Выделение будет видно с самого начала, если установлено значение true)';
$_['help_amount']     = '(Работает при зацикливании)';
$_['help_textColor']     = '(формат название(black) и #000000)';
$_['help_textBg']     = '(формат название(black) и #000000)';

//tab
$_['tab_editText']     = 'Настройка текста';
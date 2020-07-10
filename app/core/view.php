<?php

class View
{
    /**
     * @param $content_view string имя вью содержимого страницы
     * @param $tpl_view string шаблон
     * @param null $data данные для вывода на странице
     */
    function generate($content_view, $tpl_view = "layout", $data = null)
	{
		if(is_array($data)) extract($data);
		include 'app/views/'.$tpl_view.'.php';
	}
}

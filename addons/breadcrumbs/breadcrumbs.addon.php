<?php
if(!defined("__ZBXE__")) exit();

/**
* @brief This addon generates a line with links for Menu tree (Breadcrumbs menu).
* @developer Arnia (xe_dev@gmail.com) 
*/
if($called_position == 'before_display_content' && Context::getResponseMethod() == 'HTML')
{
	require_once('./addons/breadcrumbs/breadcrumbs.lib.php');
	$page_srl = Context::get('module_srl');
	$mid = getCurentMenuSrl($page_srl);
	$uri = Context::getRequestUri();
	$menu_links_output = "<a href='" . $uri . "'>Home</a>";
	if ($mid->menu_item_srl > 0)
	{
	    $menu_links = array_reverse(getMenuLinks($mid->menu_item_srl, $mid->menu_srl));
	    foreach($menu_links as $key=>$value)
	    {
	        $menu_links_output .= " -> <a href='" . $uri . "$value'>" . $key . "</a>";
		}
	}
	$text_search = '<div class="content xe_content">';
	$pos_content = strpos($output, $text_search) + strlen($text_search);
	$output = substr_replace($output, $menu_links_output, $pos_content, 0);
}
?>


<?php
/**
* @brief Recursive function that creat Menu links
* @access public
* 
* @param $mid_srl
* @param $menu_srl
* @param $list_menu_links
* 
* @return array
*/
function getMenuLinks($mid_srl, $menu_srl, $list_menu_links = array())
{
	$args->menu_item_srl = (int)$mid_srl;
	$args->menu_srl = (int)$menu_srl;

	$result = executeQuery('addons.breadcrumbs.getCurentMid', $args);
	$list_menu_links[$result->data->name] = $result->data->module_url;

	if ((int)$result->data->parent_srl > 0)
	{
		$list_menu_links = getMenuLinks($result->data->parent_srl, $menu_srl, $list_menu_links);
	}
	return $list_menu_links;
}

/**
* @brief get curent menu srl
* @access public
* 
* @param $page_srl
* 
*/
function getCurentMenuSrl($page_srl)
{
	$args->page_srl = (int)$page_srl;
	$result = executeQuery('addons.breadcrumbs.getCurentSrl', $args);
	return $result->data;
}
?>
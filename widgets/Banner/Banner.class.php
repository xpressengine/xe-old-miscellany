<?php
    /**
     * @class xe_news
     * @author zero (zero@nzeo.com)
     * @brief XE공식사이트의 배너 위젯
     * @version 0.1
     **/

    class Banner extends WidgetHandler {

        /**
         * @brief 위젯의 실행 부분
         *
         * ./widgets/위젯/conf/info.xml 에 선언한 extra_vars를 args로 받는다
         * 결과를 만든후 print가 아니라 return 해주어야 한다
         **/
        function proc($args) {
			// (skin, colorset)						
            $tpl_path = sprintf('%sskins/%s', $this->widget_path, $args->skin);
            $colorset = $args->colorset;

            //template file
            $tpl_file = 'banner';

			$maxImageNo = 5;

			if($args->banner_width && is_numeric($args->banner_width)) 
				$widget_info->banner_width = $args->banner_width;
			else 
				$widget_info->banner_width = 500;

			if($args->banner_height && is_numeric($args->banner_height)) 
				$widget_info->banner_height = $args->banner_height;
			else 
				$widget_info->banner_height = 500;

			$index = 1;
			for($i=1;$i<=$maxImageNo;$i++){
				$image_src = 'banner_'.$i;

				if($args->$image_src){
            		$widget_info->images[$index]['image_src'] = $args->$image_src;

					$image_title = 'banner_title_'.$i;
					$widget_info->images[$index]['image_title'] = $args->$image_title ? $args->$image_title : '';

					$image_description = 'banner_description_'.$i;
					$widget_info->images[$index]['image_description'] = $args->$image_description ? $args->$image_description : '';

					$image_url = 'banner_url_'.$i;
					$widget_info->images[$index]['image_url'] = $args->$image_url ? $args->$image_url : '';

					$index++;
            	}
				else
					continue;
			}

			Context::set('widget_info', $widget_info);

			$oTemplate = &TemplateHandler::getInstance();
            return $oTemplate->compile($tpl_path, $tpl_file);
        }
    }
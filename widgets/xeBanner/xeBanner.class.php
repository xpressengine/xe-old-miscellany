<?php
    /**
     * @class xe_news
     * @author zero (zero@nzeo.com)
     * @brief XE공식사이트의 배너 위젯
     * @version 0.1
     **/

    class xeBanner extends WidgetHandler {

        /**
         * @brief 위젯의 실행 부분
         *
         * ./widgets/위젯/conf/info.xml 에 선언한 extra_vars를 args로 받는다
         * 결과를 만든후 print가 아니라 return 해주어야 한다
         **/
        function proc($args) {
            //number of the image
            $imageNo = 5;

            //height,width
            $intRE = '/[0-9]+/msi';
            $widget_info->imgHeight = '396';
            if(preg_match($intRE,$args->banner_height)){
   				$widget_info->imgHeight = $args->banner_height;
            }
            $widget_info->imgWidth = '958';
            if(preg_match($intRE,$args->banner_width)){
   				$widget_info->imgWidth = $args->banner_width;
            }

            // 위젯 변수 설정
            $widget_info->info = array();
            for($i=1;$i<=$imageNo;$i++){
            	//image
            	$key = 'banner_'.$i;
            	if(empty($args->$key)){
            		continue;
            	}
            	$widget_info->info[$i]['image'] = $args->$key;

            	//title
            	$bKey = 'banner_title_'.$i;
            	$widget_info->info[$i]['title'] = $args->$bKey;

            	//descirption
            	$bKey = 'banner_description_'.$i;
            	$widget_info->info[$i]['descirption'] = $args->$bKey;

            	//url
            	$bKey = 'banner_url_'.$i;
            	$widget_info->info[$i]['url'] = $args->$bKey;
            	if(!$widget_info->info[$i]['url']) {
            		$widget_info->info[$i]['url'] = 'javascript:void()';
            	}
            	else if(!preg_match('/^http/i',$widget_info->info[$i]['url'])){
            		$widget_info->info[$i]['url'] = 'http://'.$widget_info->info[$i]['url'];
            	}
            }

            //no image add default images
            if(!count($widget_info->info)){
            	$widget_info->is_default = true;
            	for($i=1;$i<=$imageNo;$i++){
            		$key = 'banner_'.$i;
            		$widget_info->info[$i]['url'] = 'javascript:void()';
		        	$widget_info->info[$i]['image'] = getUrl().$this->widget_path.'images/'.'defaultImg'.$i.'.jpg';
            	}
            }

            //css name
            $widget_info->classPre = rand();
            Context::set('widget_info', $widget_info);

            // 템플릿의 스킨 경로를 지정 (skin, colorset에 따른 값을 설정)
            $tpl_path = sprintf('%sskins/%s', $this->widget_path, $args->skin);

            // 템플릿 파일을 지정
            $tpl_file = 'banner';

            // 템플릿 컴파일
            $oTemplate = &TemplateHandler::getInstance();
            return $oTemplate->compile($tpl_path, $tpl_file);
        }
    }
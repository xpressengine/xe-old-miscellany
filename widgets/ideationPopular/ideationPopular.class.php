<?php
    /**
     * @class ideationPopular
     * @author zero (zero@xpressengine.com)
     * @brief 한개 혹은 한개 이상의 모듈을 대상으로 최신글/댓글/인기글을 추출
     * @version 0.1
     **/

    class ideationPopular extends WidgetHandler {

        /**
         * @brief 위젯의 실행 부분
         *
         * ./widgets/위젯/conf/info.xml 에 선언한 extra_vars를 args로 받는다
         * 결과를 만든후 print가 아니라 return 해주어야 한다
         **/
        function proc($args) {
            $oDocumentModel = &getModel('document');
            $oCommentModel = &getModel('comment');

            // 글자 제목 길이
            $widget_info->subject_cut_size = (int)$args->subject_cut_size;

            // 인수 정리
            $db_args->module_srls = $args->module_srls;
            $db_args->sort_index = 'documents.list_order';
            $db_args->order_type = 'asc';
            $db_args->list_count = $args->list_count;

            // 최신글을 구함
            $output = executeQueryArray('widgets.ideationPopular.getNewestDocuments', $db_args);
            if($output->data) {
                foreach($output->data as $k => $v) {
                    $oDocument = null;
                    $oDocument = $oDocumentModel->getDocument();
                    $oDocument->setAttribute($v, false);
                    $GLOBALS['XE_DOCUMENT_LIST'][$oDocument->document_srl] = $oDocument;
                    $output->data[$k] = $oDocument;
                }
                $oDocumentModel->setToAllDocumentExtraVars();
            }
            $widget_info->newest_documents = $output->data;

            // 최신 댓글을 구함
            $db_args->sort_index = 'list_order';
            $output = executeQueryArray('widgets.ideationPopular.getNewestComments', $db_args);
            if($output->data) {
                foreach($output->data as $k => $v) {
                    $oComment = null;
                    $oComment = $oCommentModel->getComment();
                    $oComment->setAttribute($v);
                    $output->data[$k] = $oComment;
                }
            }
            $widget_info->newest_comments = $output->data;

            // 1주일 이내의 인기글을 구함
            $db_args->sort_index = 'readed_count';
            $db_args->order_type = 'desc';
            $output = executeQueryArray('widgets.ideationPopular.getPopularDocuments', $db_args);
            if($output->data) {
                foreach($output->data as $k => $v) {
                    $oDocument = null;
                    $oDocument = $oDocumentModel->getDocument();
                    $oDocument->setAttribute($v, false);
                    $GLOBALS['XE_DOCUMENT_LIST'][$oDocument->document_srl] = $oDocument;
                    $output->data[$k] = $oDocument;
                }
                $oDocumentModel->setToAllDocumentExtraVars();
            }
            $widget_info->popular_documents = $output->data;

            Context::set('widget_info', $widget_info);

            // 언어파일 로드
            Context::loadLang($this->widget_path.'lang');

            // 템플릿의 스킨 경로를 지정 (skin, colorset에 따른 값을 설정)
            $tpl_path = sprintf('%sskins/%s', $this->widget_path, $args->skin);
            Context::set('colorset', $args->colorset);

            // 템플릿 파일을 지정
            $tpl_file = 'list';

            // 템플릿 컴파일
            $oTemplate = &TemplateHandler::getInstance();
            return $oTemplate->compile($tpl_path, $tpl_file);
        }
    }
?>

<?php/** * [Laike System] Copyright (c) 2017-2020 laiketui.com * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details. */require_once(MO_LIB_DIR . '/DBAction.class.php');require_once(MO_LIB_DIR . '/ShowPager.class.php');require_once(MO_LIB_DIR . '/Tools.class.php');class IndexAction extends Action {    public function getDefaultView() {        $db = DBAction::getInstance();        $request = $this->getContext()->getRequest();        $pageto = $request -> getParameter('pageto');        $pagesize = $request -> getParameter('pagesize');        $pagesize = $pagesize ? $pagesize:'10';        $page = $request -> getParameter('page');        // 页码        if($page){            $start = ($page-1)*$pagesize;        }else{            $start = 0;        }        $sql = "select * from lkt_config where id = '1'";        $r = $db->select($sql);        $uploadImg = $r[0]->uploadImg; // 图片上传位置        $sql = "select * from lkt_banner";        $r = $db->select($sql);        $total = count($r);        $pager = new ShowPager($total,$pagesize,$page);        // 查询轮播图表，根据sort顺序排列        $sql = "select * from lkt_banner order by sort";        $r = $db->select($sql);        foreach ($r as $k => $v) {            $v->image = $uploadImg . $v->image;        }        $url = "index.php?module=banner&action=Index&pagesize=".urlencode($pagesize);;        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');        $request->setAttribute("list",$r);        $request -> setAttribute('pages_show', $pages_show);        return View :: INPUT;    }    public function execute() {    }    public function getRequestMethods(){        return Request :: NONE;    }}?>
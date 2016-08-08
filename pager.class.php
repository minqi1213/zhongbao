<?php
    /**
        file: page.class.php
        ������ҳ�� Page
    */
    class Page {
        private $total;                         //���ݱ����ܼ�¼��
        private $listRows;                      //ÿҳ��ʾ����
        private $limit;                         //SQL���ʹ��limit�Ӿ�,���ƻ�ȡ��¼����
        private $uri;                           //�Զ���ȡurl�������ַ
        private $pageNum;                       //��ҳ��
        private $page;                          //��ǰҳ  
        private $config = array(
                'head' => "����¼",
                'prev' => "��һҳ",
                'next' => "��һҳ",
                'first'=> "��ҳ",
                'last' => "ĩҳ"
            );                 
        //�ڷ�ҳ��Ϣ����ʾ���ݣ������Լ�ͨ��set()��������
        private $listNum = 10;                  //Ĭ�Ϸ�ҳ�б���ʾ�ĸ���
 
        /**
            ���췽�����������÷�ҳ�������
            @param  int $total      �����ҳ���ܼ�¼��
            @param  int $listRows   ��ѡ�ģ�����ÿҳ��Ҫ��ʾ�ļ�¼����Ĭ��Ϊ25��
            @param  mixed   $query  ��ѡ�ģ�Ϊ��Ŀ��ҳ�洫�ݲ���,���������飬Ҳ�����ǲ�ѯ�ַ�����ʽ
            @param  bool    $ord    ��ѡ�ģ�Ĭ��ֵΪtrue, ҳ��ӵ�һҳ��ʼ��ʾ��false��Ϊ���һҳ
         */
        public function __construct($total, $listRows=25, $query="", $ord=true){
            $this->total = $total;
            $this->listRows = $listRows;
            $this->uri = $this->getUri($query);
            $this->pageNum = ceil($this->total / $this->listRows);
            /*�����ж��������õ�ǰ��*/
            if(!empty($_GET["page"])) {
                $page = $_GET["page"];
            }else{
                if($ord)
                    $page = 1;
                else
                    $page = $this->pageNum;
            }
 
            if($total > 0) {
                if(preg_match('/\D/', $page) ){
                    $this->page = 1;
                }else{
                    $this->page = $page;
                }
            }else{
                $this->page = 0;
            }
             
            $this->limit = "LIMIT ".$this->setLimit();
        }
 
        /**
            ����������ʾ��ҳ����Ϣ�����Խ����������
            @param  string  $param  �ǳ�Ա��������config���±�
            @param  string  $value  ��������config�±��Ӧ��Ԫ��ֵ
            @return object          ���ر������Լ�$this�� �������߲���
         */
        function set($param, $value){
            if(array_key_exists($param, $this->config)){
                $this->config[$param] = $value;
            }
            return $this;
        }
         
        /* ����ֱ��ȥ���ã�ͨ���÷���������ʹ���ڶ����ⲿֱ�ӻ�ȡ˽�г�Ա����limit��page��ֵ */
        function __get($args){
            if($args == "limit" || $args == "page")
                return $this->$args;
            else
                return null;
        }
         
        /**
            ��ָ���ĸ�ʽ�����ҳ
            @param  int 0-7�����ֱַ���Ϊ�����������Զ��������ҳ�ṹ�͵����ṹ��˳��Ĭ�����ȫ���ṹ
            @return string  ��ҳ��Ϣ����
         */
        function fpage(){
            $arr = func_get_args();
 
            $html[0] = "<span class='p1'> ��<b> {$this->total} </b>{$this->config["head"]} </span>";
            $html[1] = " ��ҳ <b>".$this->disnum()."</b> �� ";
            $html[2] = " ��ҳ�� <b>{$this->start()}-{$this->end()}</b> �� ";
            $html[3] = " <b>{$this->page}/{$this->pageNum}</b>ҳ ";
            $html[4] = $this->firstprev();
            $html[5] = $this->pageList();
            $html[6] = $this->nextlast();
            $html[7] = $this->goPage();
 
            $fpage = '<div style="font:12px \'\5B8B\4F53\',san-serif;">';
            if(count($arr) < 1)
                $arr = array(0, 1,2,3,4,5,6,7);
                 
            for($i = 0; $i < count($arr); $i++)
                $fpage .= $html[$arr[$i]];
         
            $fpage .= '</div>';
            return $fpage;
        }
         
        /* �ڶ����ڲ�ʹ�õ�˽�з�����*/
        private function setLimit(){
            if($this->page > 0)
                return ($this->page-1)*$this->listRows.", {$this->listRows}";
            else
                return 0;
        }
 
        /* �ڶ����ڲ�ʹ�õ�˽�з����������Զ���ȡ���ʵĵ�ǰURL */
        private function getUri($query){   
            $request_uri = $_SERVER["REQUEST_URI"];
            $url = strstr($request_uri,'?') ? $request_uri :  $request_uri.'?';
             
            if(is_array($query))
                $url .= http_build_query($query);
            else if($query != "")
                $url .= "&".trim($query, "?&");
         
            $arr = parse_url($url);
 
            if(isset($arr["query"])){
                parse_str($arr["query"], $arrs);
                unset($arrs["page"]);
                $url = $arr["path"].'?'.http_build_query($arrs);
            }
             
            if(strstr($url, '?')) {
                if(substr($url, -1)!='?')
                    $url = $url.'&';
            }else{
                $url = $url.'?';
            }
             
            return $url;
        }
 
        /* �ڶ����ڲ�ʹ�õ�˽�з��������ڻ�ȡ��ǰҳ��ʼ�ļ�¼�� */
        private function start(){
            if($this->total == 0)
                return 0;
            else
                return ($this->page-1) * $this->listRows+1;
        }
 
        /* �ڶ����ڲ�ʹ�õ�˽�з��������ڻ�ȡ��ǰҳ�����ļ�¼�� */
        private function end(){
            return min($this->page * $this->listRows, $this->total);
        }
 
        /* �ڶ����ڲ�ʹ�õ�˽�з��������ڻ�ȡ��һҳ����ҳ�Ĳ�����Ϣ */
        private function firstprev(){
            if($this->page > 1) {
                $str = " <a href='{$this->uri}page=1'>{$this->config["first"]}</a> ";
                $str .= "<a href='{$this->uri}page=".($this->page-1)."'>{$this->config["prev"]}</a> ";       
                return $str;
            }
 
        }
     
        /* �ڶ����ڲ�ʹ�õ�˽�з��������ڻ�ȡҳ���б���Ϣ */
        private function pageList(){
            $linkPage = " <b>";
             
            $inum = floor($this->listNum/2);
            /*��ǰҳǰ����б� */
            for($i = $inum; $i >= 1; $i--){
                $page = $this->page-$i;
 
                if($page >= 1)
                    $linkPage .= "<a href='{$this->uri}page={$page}'>{$page}</a> ";
            }
            /*��ǰҳ����Ϣ */
            if($this->pageNum > 1)
                $linkPage .= "<span style='padding:1px 2px;background:#BBB;color:white'>{$this->page}</span> ";
             
            /*��ǰҳ������б� */
            for($i=1; $i <= $inum; $i++){
                $page = $this->page+$i;
                if($page <= $this->pageNum)
                    $linkPage .= "<a href='{$this->uri}page={$page}'>{$page}</a> ";
                else
                    break;
            }
            $linkPage .= '</b>';
            return $linkPage;
        }
 
        /* �ڶ����ڲ�ʹ�õ�˽�з�������ȡ��һҳ��βҳ�Ĳ�����Ϣ */
        private function nextlast(){
            if($this->page != $this->pageNum) {
                $str = " <a href='{$this->uri}page=".($this->page+1)."'>{$this->config["next"]}</a> ";
                $str .= " <a href='{$this->uri}page=".($this->pageNum)."'>{$this->config["last"]}</a> ";
                return $str;
            }
        }
 
        /* �ڶ����ڲ�ʹ�õ�˽�з�����������ʾ�ʹ������תҳ�� */
        private function goPage(){
                if($this->pageNum > 1) {
                return ' <input style="width:20px;height:17px !important;height:18px;border:1px solid #CCCCCC;" type="text" onkeydown="javascript:if(event.keyCode==13){var page=(this.value>'.$this->pageNum.')?'.$this->pageNum.':this.value;location=\''.$this->uri.'page=\'+page+\'\'}" value="'.$this->page.'"><input style="cursor:pointer;width:25px;height:18px;border:1px solid #CCCCCC;" type="button" value="GO" onclick="javascript:var page=(this.previousSibling.value>'.$this->pageNum.')?'.$this->pageNum.':this.previousSibling.value;location=\''.$this->uri.'page=\'+page+\'\'"> ';
            }
        }
 
        /* �ڶ����ڲ�ʹ�õ�˽�з��������ڻ�ȡ��ҳ��ʾ�ļ�¼���� */
        private function disnum(){
            if($this->total > 0){
                return $this->end()-$this->start()+1;
            }else{
                return 0;
            }
        }
    }
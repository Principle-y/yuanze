<?php
/**
 *功能：删除一级的同时，二级，三级都删除
 ·1.先判断是否三级栏目，删除三级
 ·2.然后是二级栏目，删除二级和三级
 ·3.最后是一级栏目，删除一二三级栏目
 */ 
header("Content-Type:text/html;charset=utf-8");
require_once(".\conn.php");
$id=$_GET['id'];
$lm=$_GET['lmd'];
     /*封装函数*/
    function jump()
    {
             echo"<script>
             alert('请删除本栏目下的新闻');
             history.go(-1);
             </script>";
             exit;
     }
    function delete_query_id($id_del)
    {
        $sql="delete from lm where id=".$id_del;
        $query=mysql_query($sql);
        return $query;
    }
    function delete_query_lmid($lmid_del)
    {
        $sql="delete from lm where lmid=".$lmid_del;
        $query=mysql_query($sql);
        return $query;
    }
    function select_query_assocs($lm_l,$id_s)
    {
        $sql="select * from news where $lm_l=$id_s limit 1";
        $query=mysql_query($sql);
        $res=mysql_fetch_assoc($query);
        return $res;
    }
    /*封装函数结束*/
    /*代码部分*/
    if ($lm=='lm3') {
        $res=select_query_assocs("lm3",$id);
        if (empty($res)) {
            delete_query_id($id);
        }
        else { 
            jump(); 
        }
    }   
    elseif ($lm=='lm2') {
        $res=select_query_assocs("lm2",$id);
        if (empty($res)) {
             delete_query_id($id);
             delete_query_lmid($id);
        }
        else { 
            jump();
        }    
    }
    elseif ($lm=='lm1') {
        $res=select_query_assocs("lm1",$id);
        if (empty($res)) {
        delete_query_id($id);//删除一级栏目    
        $sql="select * from lm where lmid=".$id;//在二级栏目中查找
        $query=mysql_query($sql);
        while(@$res=mysql_fetch_array($query))//屏蔽错误
        {
         delete_query_lmid($res['id']);
        }
         delete_query_lmid($id);//删除二级栏目      
        }
        else { 
            jump();
        }    
    }
     header("Location:content_lanmu.php?page=$page");
    exit;
    /*代码部分结束*/
?>

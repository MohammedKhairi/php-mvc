<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
use app\core\Request;

class Chat extends Model{
    public $send_from=0;
    public $send_to=0;
    public $content=0;
    /**
     * Database Table Info
     */
    public $dbTableName='chat';

    private $dbColums=['id','send_from','send_to','content','created','deleted'];

    public function rules():array
    {
        return[];
    }
    public function lables():array{
        return[
             'send_from'=>"ارسل من",
             'send_to'  =>"المستلم",
             'content'  =>"الرسالة",
        ];
    }
    public function getUsers(){
        $D=[];
        $user_lvl=Application::$app->session->get('user')['lvl'];
        #get employee users if the user is student
        if("student"==$user_lvl){
            $D=Application::$app->db->query('SELECT `e`.`id`, 
            `e`.`user_id`, 
            `e`.`name`,
            `e`.`img` ,
            `u`.`id` `uid` ,
            `u`.`lvl` 
            FROM `employee` `e`
            inner join `user` `u` on `e`.`user_id` =`u`.`id`
            WHERE `e`.`deleted`=0');
        }
        #get student users if the user is employee
        if("employee"==$user_lvl || "admin"==$user_lvl){
            $D=Application::$app->db->query('SELECT `s`.`id`, 
            `s`.`user_id`, 
            `s`.`name`,
            `s`.`img` ,
            `u`.`id` `uid` ,
            `u`.`lvl` 
            FROM `student` `s`
            inner join `user` `u` on `s`.`user_id` =`u`.`id`
            WHERE `s`.`deleted`=0');
        }
        return $D;
    }
    public function getOneInfo($id,$myid){
        #
        $this->whr.=' and ((`c`.`send_from`=? and `c`.`send_to`=?) or (`c`.`send_from`=? and `c`.`send_to`=?) ) ';

        $this->params[]=$id;
        $this->params[]=$myid;

        $this->params[]=$myid;
        $this->params[]=$id;
        #
        $D=Application::$app->db->query('SELECT `c`.`id`, 
        `c`.`send_from`, 
        `c`.`send_to`,
        `c`.`content` ,
        `c`.`created`
        FROM '.$this->dbTableName.' `c`
        WHERE `c`.`deleted`=0'.$this->whr.'order by `c`.`created` asc',$this->params);
        return $D;
    }
    public function insert(){
        //
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'send_from' =>$this->send_from,
            'send_to'   =>$this->send_to,
            'content'   =>$this->content,
            'created'   =>time(),
        ]);
        
        $this->setLog('chat','add',$last_id);
        return $last_id;
    }
    public function remove($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        $this->setLog('chat','remove',$id);
        return $last_id;
    }


}
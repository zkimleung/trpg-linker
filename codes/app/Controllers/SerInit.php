<?php
// 项目初始化脚本，会在镜像构建完成后执行
namespace App\Controllers;
use MongoDB;
use Parsedown;
use Config;

class SerInit extends BaseController
{
    const TOKEN_ADD = 'TRPG-LINKER';
    use \CodeIgniter\API\ResponseTrait;
    private $DB = null;
    private $session = null;

    private $collections = [ //集合名称 =》初始化数据量，0为不需要初始化
        'rotes' => 0,
        'skill_tree' => 1,
        'occupation' => 114,
        'config' => 0,
        'trpg_logs' => 0
    ];

    private function set_db(){
        $grp = config('Database')->defaultGroup;
        $db = config('Database')->$grp['database'];
        $host = sprintf(
            "mongodb://%s:%s@%s",
            config('Database')->$grp['username'],
            config('Database')->$grp['password'],
            config('Database')->$grp['hostname']
        );
        $this->DB = (new MongoDB\Client($host))->$db;
        $this->session = session();
    }

    public function index()
    {        
        $path = "../writable/uploads/introduce.md";
        $file = new \CodeIgniter\Files\File($path);
        $text = $file->openFile('r');
        $Parsedown = new Parsedown();
        $intor = "";
        while(!$text->eof()) {
            $intor .= $Parsedown->text($text->fgets());
        }
        echo view('header',['intor'=>$intor]);

        $this->set_db();
        $flag = $this->getConfig();

        helper('form');
        if (!$flag) {
            echo form_open('SerInit/init_set');
            echo form_input([
                'name'      => 'token_str',
                'id'        => 'token_str',
                'placeholder '     => '初始化口令',
                'maxlength' => '100'
            ]);
            echo form_submit('init', '进入初始化~');
            echo form_close();
        }else{
            echo anchor('Ocps/lists/1', '职业表', 'title="查看职业表"');
            echo form_open('WebRote');
            echo form_input([
                'name'      => 'token_str',
                'id'        => 'token_str',
                'placeholder '     => '输入口令',
                'maxlength' => '100'
            ]);
            echo form_submit('rote_check', '查看人物卡');
            echo form_close();
        }

        echo view('footer');
    }

    public function init_set()
    {
        $token_str = $this->request->getVar('token_str').self::TOKEN_ADD;
        $this->set_db();
        foreach ($this->collections as $col => $is_int){
            $this->DB->dropCollection($col);
            $res[$col] = $this->DB->createCollection($col);
            if ($is_int){
                $func = 'get_'.$col.'_data';
                $data = $this->$func();
                if ($is_int== 1){
                    $this->DB->$col->insertOne($data);
                }else{
                    $this->DB->$col->insertMany($data);
                }
            }
        }

        $data = $this->DB->config->insertOne([
            "install_flag" => 1,
            "token" => password_hash($token_str, PASSWORD_DEFAULT),
            "useing" => true
        ]);
        $this->session->set([
            'token'  => password_hash($token_str, PASSWORD_DEFAULT),
            'logged_in' => TRUE
        ]);
        $Parsedown = new Parsedown();
        echo view('header',['intor'=>$Parsedown->text("## ......初始化完成,现在你可以 ↓")]);
        echo anchor('Ocps/lists/1', '职业列表', 'title="查看职业列表"');
        echo view('footer');
    }

    private function getConfig(){
        
        $token = $this->session->get('token');
        if ($token){
            $flag = $this->DB->config->findOne([
                "token" => $token
            ]);
        }else{
            $flag = $this->DB->config->findOne([
                "useing" => true
            ]);
            if ($flag){
                $this->session->set([
                    'token'  => $flag->token,
                    'logged_in' => TRUE
                ]);
            }
        }
        return $flag;
    }

    private function get_occupation_data(){
        $path = "../writable/uploads/ocp.json";
        $file = new \CodeIgniter\Files\File($path);
        $json = $file->openFile('r');
        $data = json_decode($json->fgets(),true);
        return $data;
    }

    private function get_skill_tree_data(){
        return [
            "credit_rating" => 0,
            "accounting" => 5,
            "anthropology" => 1,
            "valuation" => 5,
            "archaeology" => 1,
            "skills" => [
                "performance" => 5,
                "haircut" => 5,
                "calligraphy" => 5,
                "carpenter" => 5,
                "cooking" => 5,
                "writing" => 5,
                "music_theory" => 5,
                "morris_dance" => 5,
                "opera_singing" => 5,
                "stuccoers_painters" => 5,
                "photography" => 5,
                "dance" => 5,
                "fine_arts" => 5,
                "forge" => 5,
                "pottery" => 5,
                "technical_mapping" => 5,
                "tillage" => 5,
                "typing" => 5,
                "stenography" => 5,
                "glass_tubes" => 5,
                "sewing" => 5,
                "winemaking" => 5,
                "catch_fish" => 5,
                "sculpture" => 5,
                "acrobatics" => 5
            ],
            "charm" => 15,
            "clamber" => 20,
            "computer_use" => 5,
            "cthulhu_mythos" => 0,
            "disguise" => 5,
            "dodge" => 20,
            "automobilism" => 20,
            "electrical_repairs" => 10,
            "electronics" => 1,
            "talk" => 5,
            "fistfight" => [
                "whip" => 5,
                "chainsaw" => 10,
                "axe" => 5,
                "sword" => 20,
                "hangers" => 15,
                "flail" => 10,
                "spear" => 20
            ],
            "shoot" => [
                "rifle" => 25,
                "submachine" => 15,
                "bow" => 15,
                "flamethrower" => 10,
                "machine_gun" => 10,
                "heavy_weapons" => 10
            ],
            "aid" => 30,
            "history" => 5,
            "intimidate" => 15,
            "caper" => 20,
            "language" => [],
            "tongue" => 50,
            "throwing" => 20,
            "trace" => 10,
            "low" => 5,
            "library" => 20,
            "listening" => 20,
            "locksmith" => 1,
            "mechanical_repair" => 10,
            "medicine" => 1,
            "natural" => 10,
            "navigation" => 10,
            "occultism" => 5,
            "heavy_machinery_operation" => 1,
            "persuade" => 10,
            "drive" => [
                "aerocraft" => 1,
                "boat" => 1
            ],
            "psychoanalysis" => 1,
            "psychology" => 10,
            "ride" => 5,
            "science" => [
                "geology" => 1,
                "chemistry" => 1,
                "biology" => 1,
                "mathematics" => 1,
                "astronomy" => 1,
                "physics" => 1,
                "pharmacy" => 1,
                "botany" => 1,
                "zoology" => 1,
                "cryptology" => 1,
                "engineering" => 1,
                "meteorology" => 1,
                "judicial_sciences" => 1
            ],
            "magic_hands" => 10,
            "investigation" => 25,
            "sneak" => 20,
            "swim" => 20,
            "taming_beast" => 5,
            "dive" => 1,
            "blow_up" => 1,
            "lip_reading" => 1,
            "hypnosis" => 1,
            "artillery" => 1,
            "knowledge" => []
        ];
    }
}
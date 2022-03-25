<?php namespace App\Entities;

use CodeIgniter\Entity;

class RoteSkillEnt extends Entity
{
    protected $attributes = [
        'credit_rating' => 0,    //信用评级
        'accounting' => 5,       //会计
        'anthropology' => 1,     //人类学
        'valuation' => 5,        //估价
        'archaeology' => 1,      //考古学
        'skills' => [            //技艺
            's1' => null,
            's2' => null,
            's3' => null,
        ],
        'charm' => 15,           //魅惑
        'clamber' => 20,         //攀爬
        'computer_use' => 5,     //计算机使用
        'cthulhu_mythos' => 0,   //克苏鲁神话
        'disguise' => 5,         //乔装
        'dodge' => 20,           //闪避
        'automobilism' => 20,    //汽车驾驶
        'electrical_repairs' => 10, //电气维修
        'electronics' => 1,      //电子学
        'talk' => 5,             //话术
        'fistfight' => [         //格斗
            'f1' => [
                'fight' => 25    //斗殴
            ],
            'f2' => null,
            'f3' => null,
            'damage_deepens' => '',   //伤害加深
            'physique' => 0       //体格
        ],
        'shoot' => [             //射击
            'sh1' => [
                'pistol' => 20   //手枪
            ],
            'sh2' => null,
            'sh3' => null
        ], 
        'aid' => 30,             //急救
        'history' => 5,          //历史
        'intimidate' => 15,      //恐吓
        'caper' => 20,           //跳跃
        'language' => [          //外语
            'l1' => null,
            'l2' => null,
            'l3' => null
        ],
        'tongue' => 50,          //母语
        'throwing' => 20,        //投掷
        'trace' => 10,           //追踪
        'low' => 5,              //法律
        'library' => 20,         //图书馆使用
        'listening' => 20,       //聆听
        'locksmith' => 1,        //锁匠
        'mechanical_repair' => 10,  //机械维修
        'medicine' => 1,         //医学
        'natural' => 10,         //自然学
        'navigation' => 10,      //导航
        'occultism' => 5,        //神秘学
        'heavy_machinery_operation' => 1,   //操作重型机械
        'persuade' => 10,        //说服
        'drive' => [             //驾驶
            'd1' => null
        ],
        'psychoanalysis' => 1,   //精神分析
        'psychology' => 10,      //心理学
        'ride' => 5,             //骑乘
        'science' => [           //科学
            'sc1' => null,
            'sc2' => null,
            'sc3' => null
        ],
        'magic_hands' => 10,     //妙手
        'investigation' => 25,   //侦查
        'sneak' => 20,           //潜行
        'swim' => 20,            //游泳
        'taming_beast' => 5,     //驯兽
        'dive' => 1,             //潜水
        'blow_up' => 1,          //爆破
        'lip_reading' => 1,      //唇语
        'hypnosis' => 1,         //催眠
        'artillery' => 1,        //炮术
        'knowledge' => []        //学问
    ];

    protected $casts = [
        'skills' => 'array',
        'fistfight' => 'array',
        'shoot' => 'array',
        'language' => 'array',
        'science' => 'array',
        'drive' => 'array',
        'knowledge' => 'array'
    ];

    protected $skills_list = [
        'performance' => 5,     //表演
        'haircut' => 5,         //理发
        'calligraphy' => 5,     //书法
        'carpenter' => 5,       //木匠
        'cooking' => 5,         //厨艺
        'writing' => 5,         //写作
        'music_theory' => 5,     //乐理
        'morris_dance' => 5,     //莫里斯舞
        'opera_singing' => 5,     //歌剧歌唱
        'stuccoers_painters' => 5,     //粉刷匠与油漆工
        'photography' => 5,     //摄影
        'dance' => 5,       //舞蹈
        'fine_arts' => 5,     //美术
        'forge' => 5,       //伪造
        'pottery' => 5,     //制陶
        'technical_mapping' => 5,     //技术制图
        'tillage' => 5,         //耕作
        'typing' => 5,          //打字
        'stenography' => 5,     //速记
        'glass_tubes' => 5,     //吹制玻璃管
        'sewing' => 5,          //缝纫
        'winemaking' => 5,     //酿酒
        'catch_fish' => 5,     //捕鱼
        'sculpture' => 5,     //雕塑
        'acrobatics' => 5,     //杂技
    ];
    protected $fistfight_list = [
        'whip' => 5,        //鞭子
        'chainsaw' => 10,     //电锯
        'axe' => 5,         //斧
        'sword' => 20,     //剑
        'hangers' => 15,     //绞具
        'flail' => 10,     //连枷
        'spear' => 20,     //矛
    ];
    protected $shoot_list = [
        'rifle' => 25,          //步枪
        'submachine' => 15,     //冲锋枪
        'bow' => 15,            //弓
        'flamethrower' => 10,     //火焰喷射器
        'machine_gun' => 10,     //机关枪
        'heavy_weapons' => 10,     //重武器
    ];
    protected $language_list = [];
    protected $science_list = [
        'geology' => 1,     //地质学
        'chemistry' => 1,     //化学
        'biology' => 1,     //生物学
        'mathematics' => 1,     //数学
        'astronomy' => 1,     //天文学
        'physics' => 1,     //物理学
        'pharmacy' => 1,     //药学
        'botany' => 1,     //植物学
        'zoology' => 1,     //动物学
        'cryptology' => 1,     //密码学
        'engineering' => 1,     //工程学
        'meteorology' => 1,     //气象学
        'judicial_sciences' => 1,     //司法科学
    ];
    protected $drive_list = [
        'aerocraft' => 1,     //飞行器
        'boat' => 1,     //船
    ];
    protected $knowledge_list = [];

    public function getSkillList(string $skill_type=''){
        $skill_type .= '_list';
        return $this->$skill_type;
    }

    public function setSkillList(string $skill_type='',array $list=[]){
        $skill_type .= '_list';
        if (isset($this->$skill_type)){
            $this->$skill_type = $list;
        }
    }

    public function fillSkillList(string $skill_type="", array $adds=[]){
        $list = $this->$skill_type;
        $count = count($this->$skill_type);
        $skill_type .= '_list';

        if ($skill_type == 'knowledge_list'){
            foreach ($adds as $key => $value) {
                $count++;
                $kk = "knl". $count; 
                $list[$kk] = [$key => $value];
            }
        }else{
            foreach ($adds as $key => $value) {
                foreach($list as $kk => $ii){
                    if(isset($this->$skill_type) && empty($ii) ) {
                        if (isset($this->$skill_type[$key])){
                            $list[$kk] = [$key => $value];
                            $count--;
                            break 1;
                        }elseif($skill_type == 'language_list'){
                            $list[$kk] = [$key => $value];
                            $count--;
                            break 1;
                        }
                    }
                }
                if ($count == 0){
                    break;
                }
            }
        }
        
        return $list;
    }

    public function sycSkillByAttr(array $attrs = []){
        $this->sycTongue($attrs['EDU']);
        $this->sycDodge($attrs['DEX']);
        $this->sycFighting($attrs['STR'] + $attrs['SIZ']);
    }

    private function sycTongue(int $EDU=0)
    {
        $this->tongue = $EDU;
    }

    private function sycDodge(int $DEX=0)
    {
        $this->dodge = (int)($DEX / 2);
    }

    private function sycFighting(int $sum=0)
    {
        switch (true) {
            case $sum < 65:
                $dam['damage_deepens'] = '-2';
                $dam['physique'] = -2;
                break;
            
            case $sum < 85:
                $dam['damage_deepens'] = '-1';
                $dam['physique'] = -1;
                break;
            
            case $sum < 125:
                $dam['damage_deepens'] = '0';
                $dam['physique'] = 0;
                break;
            
            case $sum < 165:
                $dam['damage_deepens'] = '+1D4';
                $dam['physique'] = 1;
                break;

            case $sum < 205:
                $dam['damage_deepens'] = '+1D6';
                $dam['physique'] = 2;
                break;

            case $sum < 285:
                $dam['damage_deepens'] = '+2D6';
                $dam['physique'] = 3;
                break;

            case $sum < 365:
                $dam['damage_deepens'] = '+3D6';
                $dam['physique'] = 4;
                break;

            case $sum < 445:
                $dam['damage_deepens'] = '+4D6';
                $dam['physique'] = 5;
                break;

            default:
                $dam['damage_deepens'] = '+5D6';
                $dam['physique'] = 6;
                break;
        }
        $this->fistfight = array_merge($this->fistfight, $dam);
    }

}
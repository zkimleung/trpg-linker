<script src="https://unpkg.com/vue@next"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<!-- <div > -->
<div id="attrs-basic" class="rote">
    <!-- <form @submit.prevent="sub_rote($event)" id="attrs-basic" class="rote" enctype="multipart/form-data"> -->
        
        人物头像：<input type="file" name="avatar" id="avatar">
        人物名称：<input type="text" name="name" v-model.trim="profile.name" placeholder="全名">
        年龄：<input type="text" name="age" v-model.number="profile.age" placeholder="人物年龄">
        力量：<input type="text" name="STR" v-model.number="attribute.STR" placeholder="STR">
        敏捷: <input type="text" name="DEX" v-model.number="attribute.DEX" placeholder="DEX">
        智力: <input type="text" name="INT" v-model.number="attribute.INT" placeholder="INT">
        体质: <input type="text" name="CON" v-model.number="attribute.CON" placeholder="CON">
        意志: <input type="text" name="POW" v-model.number="attribute.POW" placeholder="POW">
        外貌: <input type="text" name="APP" v-model.number="attribute.APP" placeholder="APP">
        体型: <input type="text" name="SIZ" v-model.number="attribute.SIZ" placeholder="SIZ">
        教育: <input type="text" name="EDU" v-model.number="attribute.EDU" placeholder="EDU">
        幸运: <input type="text" name="Luck" v-model.number="attribute.Luck" placeholder="幸运值">
        选择职业：
        <select name="ocp" id="ocp_sel" v-model.number="profile.occupation">
            <?php foreach ($ocps as $item):?>

                <option value=<?= $item->no ?>><?= $item->name ?></option>

            <?php endforeach;?>
        </select>

        人物性别：
        <select name="sex" id="sex" v-model="profile.sex">
            <option value="none" selected disabled hidden>选择性别</option>
            <option value="nuknow" >未知</option>
            <option value="male">男性</option>
            <option value="female">女性</option>
        </select>
        
        <hr align=center width=100% color=#909090 size=1 >

        PC: <input type="text" name="pc" v-model.trim="profile.pc" placeholder="玩家是谁？">

        <button type="submit" @click="sub_rote" >创建</button>
        <!-- <input type="submit" value="创建"> -->
    </form>
</div>
<script>
    const roteForm = Vue.createApp({
        data() {
            return {
                attribute:{
                    STR: "",
                    DEX: "",
                    INT: "",
                    CON: "",
                    POW: "",
                    APP: "",
                    SIZ: "",
                    EDU: "",
                    Luck: ""
                },
                profile:{
                    name: "",
                    age: "",
                    born_age: "现代",
                    occupation: 0,
                    sex: "",
                    pc: "",
                    idiosyncrasy: {}
                }
            }
        },
        methods: {
            sub_rote(event) {
                let rote = {
                    "attribute":this.attribute,
                    "profile":this.profile,
                    "skills": {},
                    "edu_roll": 0,
                    "luky2": 0
                }
                console.log(JSON.stringify(rote));
            }
        }
    }).mount('#attrs-basic')
</script>
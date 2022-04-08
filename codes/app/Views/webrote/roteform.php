<script src="https://unpkg.com/vue@next"></script>
<form action="/WebRote/create" method="post" class="rote" enctype="multipart/form-data">
    
    人物头像：<input type="file" name="avatar" id="avatar">
    人物名称：<input type="text" name="name">
    年龄：<input type="text" name="age">
    力量：<input type="text" name="STR">
    敏捷: <input type="text" name="DEX">
    智力: <input type="text" name="INT">
    体质: <input type="text" name="CON">
    意志: <input type="text" name="POW">
    外貌: <input type="text" name="APP">
    体型: <input type="text" name="SIZ">
    教育: <input type="text" name="EDU">
    幸运: <input type="text" name="Luck">
    选择职业：
    <select name="ocp" id="">
        <?php foreach ($ocps as $item):?>

            <option value="<?= $item->no ?>"><?= $item->name ?></option>

        <?php endforeach;?>
    </select>

    人物性别：
    <select name="sex" id="">
        <option value="nuknow">未知</option>
        <option value="male">男性</option>
        <option value="female">女性</option>
    </select>
    
    <hr align=center width=100% color=#909090 size=1 >

    PC: <input type="text" name="pc">

    <!-- <button type="submit" value="upload">创建</button> -->
    <input type="submit" value="创建">
</form>

<script>
    
</script>
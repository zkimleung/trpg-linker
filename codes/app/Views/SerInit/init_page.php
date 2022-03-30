
<!-- CONTENT -->

<section>

	

</section>


<div class="further">

	<section>

		
	</section>

</div>

<div id="app">
    <input type="text" v-model="name" placeholder="你的名字">
    <p>hello, {{ name }}</p>
</div>

<script>
    const Counter = {
        data() {
            return {
                name: "<?= $name ?>"
            }
        },
        mounted() {
            
        }
    }
    Vue.createApp(Counter).mount('#app')
</script>

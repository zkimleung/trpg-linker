
<div id="rote-info">
    <?= $profile->name ?>
</div>

<script>
    const roteInfo = Vue.createApp({
        data() {
            return {
                info: {}
            }
        },
        methods: {
            // 
        }
    }).mount('#rote-info')
</script>
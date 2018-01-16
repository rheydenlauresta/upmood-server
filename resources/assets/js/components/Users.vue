<template>
    
</template>

<script>
    export default {
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                base_url: window.base_url
            }
        },
        mounted() {
            $(".main-header > .title").html('<i class="header-ic ic-user-green"></i>Users');
        }
    }
</script>

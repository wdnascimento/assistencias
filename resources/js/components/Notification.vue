<template>
        <notifications group="foo" />
</template>

<script>
    export default {
        this.notify({
            group: 'foo',
            title: 'Important message',
            text: 'Hello user! This is a notification!'
            })
    }
</script>

<template>
    <div class="steps-header">
        <div class="steps-wrapper">
            <a href="javascript:void(0);" style="left: 0;" @click="$parent.$parent.logout()" v-if="step == 1 && this.$store.state.user.wizard != 1 && this.$route.path == '/welcome'" class="left signout-btn">Sign out </a>
            <a class="indicator left" @click="$router.go(-1)" v-else ></a>
            <h3 v-if="complete && this.$store.state.isEdit">All changes saved!</h3>
            <h3 v-else-if="complete">Set up complete!</h3>
            <h3 v-else>{{ this.$store.state.isEdit == true?"Edit Detail":"Set up" }}</h3>
        </div>
        <div class="steps-strips">
            <div v-for="index in count" :key="index" :class="[{'active':index <= step},{'buyer-steps':!$store.getters.isSeller},'strips-bx']"></div>
        </div>
        <div class="steps-counter" v-show="complete" v-if="!this.$store.state.isEdit"><span>Set up complete!</span></div>
        <div class="steps-counter" v-show="!complete"><span>Step {{ step }}</span> of {{ count }}</div>
    </div>
</template>
<script>
    export default {
       	props: ['step', 'complete'],
        data(){
            return {
                count: this.$store.getters.isSeller?9:3
            }
        }
    };
</script>

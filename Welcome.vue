<template>
    <section id="loading-game" class="w-100">
        <div class="d-flex justify-content-between align-items-center flex-column h-100 p-3-5">
            <div class="d-flex gap-4 flex-column w-100 align-items-center">
                <img src="/assets/imgs/leb-2.png" class="flag" />
                <h5>Port Beirut</h5>
            </div>
            <div class="loading-container d-flex flex-column align-items-center gap-1">
                <h6>Loading game</h6>
                <div class="loading">
                    <div class="loading-bar"></div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    mounted() {
        setTimeout(() => window.location.href = 'game', 5000)
    }
}
</script>

<style scoped>

.loading-bar {
    width: 0;
    background: #5db0a1;
    animation: grow 5s forwards;
}
@keyframes grow {
    to { width: 100%; }
}
</style>

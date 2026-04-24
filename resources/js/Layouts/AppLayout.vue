<template>
    <div class="app-shell">
        <main class="app-shell__main">
            <slot />
        </main>
    </div>
</template>

<style scoped>
.app-shell {
    min-height: 100vh;
    display: grid;
    place-items: center;
    padding: 32px;
}

.app-shell__main {
    width: min(960px, 100%);
}
</style>


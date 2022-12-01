<template>
    <div class="flex flex-col h-screen bg-gray-900">
        <nav
            class="grow-0 shrink-0 basis-16 bg-slate-900 border border-gray-600"
        ></nav>

        <div class="grow-0 shrink basis-full overflow-hidden">
            <router-view />
        </div>
    </div>
</template>

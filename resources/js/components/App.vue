<script setup>
import { onBeforeMount } from "vue";

const midtransClientKey = import.meta.env.VITE_MIDTRANS_CLIENT_KEY;

onBeforeMount(() => {
    const script = document.createElement("script");
    script.src = "https://app.sandbox.midtrans.com/snap/snap.js";
    script.setAttribute("data-client-key", midtransClientKey);
    document.body.appendChild(script);
});
</script>

<template>
    <div>
        <h1>Laravel + Vue Router Example</h1>
        <nav>
            <router-link to="/">Home</router-link> |
            <router-link to="/about">About</router-link> |
            <router-link to="/midtrans">Test Midtrans</router-link>
        </nav>
        <router-view />
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";

const snapToken = ref(null);

async function payNow() {
    const { data } = await axios.post("/api/test-create-transaction");
    snapToken.value = data.snap_token;

    window.snap.pay(snapToken.value, {
        onSuccess: (result) => {
            console.log("success", result);
        },
        onPending: (result) => {
            console.log("pending", result);
        },
        onError: (result) => {
            console.error("error", result);
        },
        onClose: () => {
            alert("Kamu menutup popup tanpa menyelesaikan pembayaran");
        },
    });
}
</script>

<template>
    <button id="pay-button" @click="payNow">Pay</button>
</template>

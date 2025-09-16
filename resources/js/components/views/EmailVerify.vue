<script setup>
import { useRoute } from "vue-router";
import axios from "axios";

const route = useRoute();

const verifyEmail = async () => {
    try {
        const id = route.params.id;
        const hash = route.params.hash;
        const query = route.query;

        const response = await axios.get(`/api/email/verify/${id}/${hash}`, {
            params: query,
        });

        console.log(response.data);
    } catch (error) {
        console.error(error);
    }
};

verifyEmail();
</script>

<template></template>

<template>
    <nav>
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"
                :class="[
                  link.url === null ? 'disabled' : '',
                  link.active ? 'active'  : ''
                ]"
                v-for="(link, index) in links"
                :key="index"
            >
                <inertialink class="page-link" :href="link.url === null ? '#' :link.url" v-html="link.label"></inertialink>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: ['links']
}
</script>

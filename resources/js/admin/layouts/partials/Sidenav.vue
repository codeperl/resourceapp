<template>
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header">
                <div class="d-flex justify-content-between">
                    <div class="toggler">
                        <a href="#" @click.prevent class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul class="menu">
                    <li class="sidebar-title">Menu</li>

                    <li class="sidebar-item" :class='setActive("/")'>
                        <router-link to='/' class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Resources</span>
                        </router-link>
                    </li>

                    <li class="sidebar-item" :class='setActive("/resource-types")'>
                        <router-link to='/resource-types' class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Resource Types</span>
                        </router-link>
                    </li>
                </ul>
            </div>
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>
</template>
<script>
    export default {
        name: "Sidenav",
        data() {
            return {};
        },

        methods: {
            setActive(input) {
                if (this.subIsActive(input)) {
                    return ' active ';
                }
            },

            subIsActive(input) {
                const paths = Array.isArray(input) ? input : [input];

                return paths.some(path => {
                    return this.$route.path === path;
                });
            },
        }
    }
</script>

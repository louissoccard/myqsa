<template>
    <div>
        <MainMenuItem :active="current('dashboard')" :href="route('dashboard')" icon="layout">Dashboard
        </MainMenuItem>

        <SubMenu v-if="permissions.includes('qsa.has')" :active="current('award.*')" :href="route('award.index')" icon="award">
            <SubMenuItem active-colour-class="bg-navy" :active="current('award.membership.show')" :href="route('award.membership.show')">Membership</SubMenuItem>
            <SubMenuItem active-colour-class="bg-teal" :active="current('award.nights-away.show')" :href="route('award.nights-away.show')">Nights Away</SubMenuItem>
            <SubMenuItem active-colour-class="bg-pink" :active="current('award.icv-list.show')" :href="route('award.icv-list.show')">ICV List</SubMenuItem>
            <SubMenuItem active-colour-class="bg-yellow" :active="current('award.dofe.show')" :href="route('award.dofe.show')">DofE</SubMenuItem>
        </SubMenu>

        <MainMenuItem v-if="canAccessMyParticipants" :active="false" :href="route('dashboard')" icon="users">My Participants</MainMenuItem>
        <MainMenuItem v-if="canAccessAdminCentre" :active="current('admin-centre.*')" :href="route('admin-centre.index')" icon="grid">Admin Centre</MainMenuItem>

        <div class="w-full my-3 px-3">
            <div class="w-full h-0.5 border-b border-gray-200 dark:border-gray-700"></div>
        </div>

        <MainMenuItem :active="false" :href="route('dashboard')" icon="help-circle" padding-y="py-2"
                      class="font-bold">Help
        </MainMenuItem>
        <MainMenuItem :active="false" :href="route('dashboard')" icon="inbox" padding-y="py-2" class="font-bold">
            Feedback
        </MainMenuItem>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import MainMenuItem from "@/Components/Interface/MainMenuItem";
import SubMenu from "@/Components/Interface/SubMenu";
import SubMenuItem from "@/Components/Interface/SubMenuItem";

export default defineComponent({
    components: {SubMenuItem, SubMenu, MainMenuItem},
    props: {permissions: Array},
    data() {
      return {
          currentRoute: this.route().current()
      }
    },
    watch: {
        '$page.url': function () {
            this.currentRoute = this.route().current()
        },
    },
    computed: {
        canAccessMyParticipants() {
            return this.permissions.filter(item => item.match('^participants\..*$')).length > 0;
        },

        canAccessAdminCentre() {
            return this.permissions.filter(item => item.match('^admin-centre\..*$')).length > 0;
        }
    },
    methods: {
        current(route) {
            if (route === this.currentRoute) return true;
            else if (route.charAt(route.length - 1) === '*' && this.currentRoute.startsWith(route.substring(0, route.length - 1))) return true;
            return false;
        }
    }
})
</script>

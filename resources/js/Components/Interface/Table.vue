<template>
    <div class="flex justify-between items-center mb-2">
        <Input id="search" label="Search" :hide-label="true" placeholder="Search..." v-model="search" v-if="searchable"
               class="relative w-full max-w-xs" input-class="border-gray-200 dark:border-gray-700">
            <Feather icon="search" :size="20"
                     class="absolute text-gray-600 dark:text-gray-300 top-2 right-3 pointer-events-none"/>
        </Input>
        <slot name="header"></slot>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead
                class="font-bold text-left bg-gray-200 dark:bg-gray-800 border-b-2 border-gray-300 dark:border-gray-700">
            <tr>
                <th class="p-2" v-for="column of columns" :key="column.name"
                    :class="[{'hover:bg-gray-300 dark:hover:bg-gray-700 cursor-pointer': column.sortable, 'w-20': column.name === 'index'}, column.class]"
                    @click="setSortBy(column)">
                    <div class="flex items-center">
                        <p> {{ column.name === 'index' ? '#' : column.name }} </p>
                        <div class="flex items-center" v-if="column.sortable">
                            <Feather icon="chevron-down" v-show="column.sorted === 'asc'" :size="16" class="ml-1"/>
                            <Feather icon="chevron-up" v-show="column.sorted === 'desc'" :size="16" class="ml-1"/>
                            <Feather icon="minus" v-show="column.sorted !== 'asc' && column.sorted !== 'desc'"
                                     :size="16"
                                     class="ml-1"/>
                        </div>
                    </div>
                </th>
                <th class="max-w-14" v-if="clickable"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="tableData.length === 0">
                <td class="px-2 py-4 text-center"
                    :colspan="columns.length + (numbered === true ? 1 : 0) + (clickable === true ? 1 : 0)">
                    {{ emptyMessage }}
                </td>
            </tr>
            <tr v-for="row of filterTableData(tableData)" :key="row.id" @click="emitClick(row.id)"
                class="border-b border-gray-200 dark:border-gray-700"
                :class="[{ 'hover:bg-gray-100 dark:hover:bg-gray-900 cursor-pointer': clickable }]">
                <td v-for="column of columns" class="p-2" :class="column.class">
                    {{ column.formatter !== undefined ? column.formatter(row[colName(column)]) : row[colName(column)] }}
                </td>
                <td v-if="clickable" class="p-2 text-center">
                    <div class="flex items-center justify-center h-full">
                        <Feather icon="chevron-right" class="h-full" :size="20"/>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import Input from "@/Components/Forms/Input";
import Feather from "@/Components/Feather";
import _ from "lodash";

export default defineComponent({
    components: {Input, Feather},
    emits: ['click'],
    props: {
        columns: {
            type: Array,
            required: true,
        },
        tableData: {
            type: Array,
            required: true,
        },
        numbered: {
            type: Boolean,
            required: false,
            default: false,
        },
        clickable: {
            type: Boolean,
            required: false,
            default: false,
        },
        emptyMessage: {
            type: String,
            required: false,
            default: false,
        }
    },

    data() {
        return {
            search: '',
        }
    },

    watch: {
        tableData: {
            immediate: true,
            deep: true,
            handler() {
                if (this.numbered) {
                    this.columns.unshift({name: "index", sortable: true, sorted: 'asc'});
                }
            }
        }
    },

    methods: {
        setSortBy(column) {
            let sorted = 'asc';
            if (column.sorted === 'asc') {
                sorted = 'desc';
            }

            this.columns.map(x => {
                if (x.name === column.name) x.sorted = sorted;
                else x.sorted = null;
            });

            this.$forceUpdate();
        },

        filterTableData(data) {
            let array = data.map((x, index) => {
                return {...x, index: index + 1}
            });

            let sort = this.columns.filter(x => x.sorted === 'asc' || x.sorted === 'desc');
            if (sort.length === 1) {
                array = _.orderBy(array, sort[0].name.toLowerCase(), sort[0].sorted);
            }

            if (this.search !== '' && this.search !== null) {
                let searchable = this.columns.filter(x => x.searchable === true);
                if (searchable.length > 0) {
                    array = array.filter(x => {
                        let found = false;
                        searchable.forEach(s => {
                            let value = x[s.name.toLowerCase()];
                            if (value.toLowerCase().startsWith(this.search.toLowerCase())) found = true;
                            else for (let term of value.split(' ')) {
                                if (term.toLowerCase().startsWith(this.search.toLowerCase())) found = true;
                            }
                        });
                        return found;
                    });
                }
            }

            return array;
        },

        emitClick(id) {
            if (this.clickable) {
                this.$emit('click', id);
            }
        },

        colName(column) {
            return column.key === undefined ? column.name.toLowerCase().replaceAll(' ', '_') : column.key;
        }
    },

    computed: {
        searchable() {
            let searchableColumns = this.columns.filter(x => x.searchable === true);
            return searchableColumns.length > 0;
        }
    }

})
</script>

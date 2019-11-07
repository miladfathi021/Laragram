<template>
    <ais-instant-search :search-client="searchClient" index-name="users" class="w-full relative">
        <ais-search-box placeholder="Are you looking for someone...?" >
            <div slot-scope="{ currentRefinement, isSearchStalled, refine }" class="w-full">
                <input
                    class="bg-gray-200 px-4 py-2 w-full rounded text-gray-700 border focus:outline-none focus:border-indigo-500 w-full pl-12"
                    type="search"
                    placeholder="Are you looking for someone...?"
                    @keyup="showResult"
                    v-model="currentRefinement"
                    @input="refine($event.currentTarget.value)"
                >
            </div>
        </ais-search-box>
        <ais-hits v-if="show" class="absolute w-full bg-white rounded shadow-lg p-4">
            <template
                slot="item"
                slot-scope="{ item }"
            >
                <a :href="item.path" class="text-gray-500 block py-2 hover:bg-indigo-100 px-2 rounded mb-1">
                    <ais-highlight
                        :hit="item"
                        attribute="name"
                    />
                </a>
            </template>
        </ais-hits>
    </ais-instant-search>
</template>

<script>
    import algoliasearch from 'algoliasearch/lite';

    export default {
        props: ['token', 'identification'],

        data() {
            return {
                searchClient: algoliasearch(
                    this.identification,
                    this.token
                ),
                show: false,
            };
        },
        methods: {
            showResult (event) {
                if (event.target.value === '') {
                    this.show = false;
                    return;
                }

                this.show = true;
            }
        }
    };
</script>

<style>
    mark {
        background-color: transparent;
        color: #667eea;
    }
</style>

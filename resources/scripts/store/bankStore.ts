import { defineStore } from "pinia";
import axios from "axios";
import { ref } from "vue"

export const useBankStore = defineStore('bankStore', {
    state: () => ({
        banks: [],
        loading: false, 
        bank: ref(''),
    }),

    actions: {
        async getBanks(search: string) {
            this.loading = true
            const res = await axios.get(`/api/get/banks`, {
                params: {
                    search: search
                }
            })

            this.banks = await res.data
            this.loading = false
        },
    }


})

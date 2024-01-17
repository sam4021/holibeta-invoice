import { defineStore } from "pinia";
import axios from "axios";
import { ref } from "vue"

export const useLocationStore = defineStore('locationStore', {
    state: () => ({
        countries: [],
        cities: [],
        localities: [],
        loading: false,
        default_country: ref({}),
        phone: ref(''),
        city: ref('')

    }),

    actions: {
        async getCountries(search: string) {
            this.loading = true
            const res = await axios.get(`/api/get/countries`, {
                params: {
                    search: search
                }
            })

            this.countries = await res.data
            this.loading = false
        },
        async getCities(country: string) {
            this.loading = true
            const res = await axios.post('https://countriesnow.space/api/v0.1/countries/cities', {
                country: country
            })
            this.cities = await res.data.data
            this.loading = false
        },
        async getDefaultCountry() {
            this.loading = true
            
            const res = await fetch(`/api/get/default_country`)
            console.log(res);
            this.default_country = await res.json()
            console.log(this.default_country);
            console.log(this.default_country.name);
            

            // @ts-ignore
            await this.getCities(this.default_country.name)
            this.loading = false
        }
    }


})

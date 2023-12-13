import {defineStore} from "pinia";
import axios from "axios";
import {ref} from "vue"

export const useLocationStore=defineStore('locationStore',{
    state:()=>({
        countries:[],
        cities:[],
        localities:[],
        loading:false,
        default_county:ref({}),
        phone:ref(''),
        city:ref(''),
        subcounty:ref(''),
        counties: [],
        subCounties: [],
    }),

    actions:{
        async getCountries(search:string){
            this.loading = true
            const res= await axios.get(`/api/get/countries`,{
                params:{
                    search:search
                }
            })

            this.countries=await res.data
            this.loading=false
        },
        async getCounties(search: string) {
            this.loading = true
            const res = await axios.get(`/api/get/counties`, {
                params: {
                    search: search
                }
            })

            this.counties = await res.data
            this.loading = false
        },
        async getSubcounties(county:number) {
            this.loading = true
            const res = await axios.get(`/api/get/sub-counties/${county}`, {
                params: {
                    county: county
                }
            })
            
            this.subCounties = await res.data
            this.loading = false
        },

        async getDefaultCounty(){
            this.loading = true

            const res= await fetch(`/api/get/default_county`)
            this.default_county=await res.json()
            // @ts-ignore
            await this.getSubcounties(this.default_county.id)
            this.loading=false
        }
    }


})

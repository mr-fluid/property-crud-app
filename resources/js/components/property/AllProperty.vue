<template>
    <div class="row">
        <div class="col-12 mb-2 text-end">
        <router-link :to='{name:"propertyAdd"}' class="btn btn-primary">Add Property</router-link>
        <button type="button" @click="updatePropertyApi()" class="btn btn-warning">Update Properties from API</button>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Properties</h4>
                </div>
                <div v-if="properties.length > 0" class="card-body">
        
                <div v-for="property in properties">
                    <div class="card p-3 m-3" style="width: 100%;">
                    <img class="card-img-top" v-if="property.data_source == 'local'" :src="'/image/'+property.image_full" alt="Property Image">
                    <img class="card-img-top" v-else :src="property.image_full" alt="Property Image">
                    <div class="card-body">
                        <p class="card-text"><strong>County:</strong>{{ property.county }} | <strong>Country:</strong>{{ property.country }} | <strong>Town:</strong>{{ property.town }}</p>
                        <p class="card-text"><strong>Address:</strong>{{ property.address }} | <strong>Postcode:</strong>{{ property.postcode }} | <strong>Longitude:</strong>{{ property.longitude }} | <strong>Latitude:</strong>{{ property.latitude }}</p>
                        <p class="card-text"><strong>Description:</strong>{{ property.description }}</p>
                        <p class="card-text"><strong>No. of Bedrooms:</strong>{{ property.num_bedrooms }} | <strong>No. of Bathrooms:</strong>{{ property.num_bathrooms }}</p>
                        <p class="card-text"><strong>Price:</strong>{{ property.price }} | <strong>Type:</strong>{{ property.type }} | <strong>Property Type:</strong>{{ property.property.title }}</p>
                    </div>
                     <div class="card-footer ">
                         <router-link :to='{name:"propertyEdit",params:{id:property.uuid}}' class="btn btn-success">Edit</router-link>
                                        <button type="button" @click="deleteProperty(property.uuid)" class="btn btn-danger">Delete</button>
                    </div>
                    </div>
                </div>
                </div>
                <div v-else class="card-body">
                <h4>No Properties found</h4>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"properties",
    data(){
        return {
            properties:[]
        }
    },
    mounted(){
        this.getProperties()
    },
    methods:{
        async getProperties(){
            await this.axios.get('/api/admin').then(response=>{
                this.properties = response.data
            }).catch(error=>{
                console.log(error)
                this.properties = []
            })
        },
           deleteProperty(id){
            if(confirm("Are you sure you want to delete this property ?")){
                this.axios.delete(`/api/admin/${id}`).then(response=>{
                    this.getProperties()
                }).catch(error=>{
                    console.log(error)
                })
            }
        },
        updatePropertyApi(id){
            if(confirm("Are you sure you want to Update properties from API ?")){
                this.axios.get('/api/fetchFromApi').then(response=>{ 
                    this.getProperties()
                }).catch(error=>{
                    console.log(error)
                })
            }
        }
    }
}
</script>
<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Update property</h4>
                </div>
                <div class="card-body">
                    <form @submit.prevent="update">
                     <div v-for="(errorArray, idx) in errors" :key="idx">
                        <div v-for="(allErrors, idx) in errorArray" :key="idx">
                           <div class="alert alert-danger" role="alert">
                            {{allErrors}}
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>County</label>
                                    <input type="text" class="form-control" v-model="property.county">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" class="form-control" v-model="property.country">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Town</label>
                                    <input type="text" class="form-control" v-model="property.town">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Postcode</label>
                                    <input type="text" class="form-control" v-model="property.postcode">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" v-model="property.description"></textarea>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Displayable address</label>
                                    <input type="text" class="form-control" v-model="property.address">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Upload Image</label>
                                     <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" 
                                            ref="file" @change="handleFileObject()">
                                        <label class="custom-file-label text-left" for="customFile">{{ imageName }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Number of Bedrooms</label>
                                     <select class="form-control" v-model="property.num_bedrooms">
                                    <option disabled value="">Please select one</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Number of Bathrooms</label>
                                    <select class="form-control" v-model="property.num_bathrooms">
                                    <option disabled value="">Please select one</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    </select>                              
                                      </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control" v-model="property.price">
                                </div>
                            </div>
                              <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Property Type</label>
                                    <select class="form-control" v-model="property.property_type">
                                    <option disabled value="">Please select one</option>
                                   <option value="1">Flat</option>
                                    <option value="2">Detached</option>
                                    <option value="3">Semi-Detached</option>
                                    </select>
                                </div>
                            </div>
                              <div class="col-12 mb-2">
                                <div class="form-group">
                                    <div>Type</div>
                                    <input type="radio" name="type"  value="rent" v-model="property.type" >
                                    <label for="type">For Rent</label>

                                    <input type="radio" name="type"  value="sale" v-model="property.type" >
                                    <label for="type">For Sale</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"update-property",
    data(){
        return {
             errors:null,
            property:{
                county:"",
                country:"",
                image: null,
                _method:"patch"
            },
            imageName: null,
        }
    },
    mounted(){
        this.showproperty()
    },
    methods:{
        async showproperty(){
        
            await this.axios.get(`/api/admin/${this.$route.params.id}`).then(response=>{
                const { county, country, town, description, postcode, address, num_bedrooms, num_bathrooms, price, type, property_type } = response.data
                this.property.county = county
                this.property.country = country
                this.property.town = town
                this.property.description = description
                this.property.postcode = postcode
                this.property.address = address
                this.property.num_bedrooms = num_bedrooms
                this.property.num_bathrooms = num_bathrooms
                this.property.price = price
                this.property.type = type
                this.property.property_type = property_type
            }).catch(error=>{
                console.log(error)
            })
        },
        async update(){
        let property = new FormData()
        property.append('image', this.image)

        _.each(this.property, (value, key) => {
          property.append(key, value)
        })

            await this.axios.post(`/api/admin/${this.$route.params.id}`,property, {
            headers: {
              'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)
              }
            }).then(response=>{
                this.$router.push({name:"propertyList"})
            }).catch(error=>{this.errors=error.response.data.errors})
        },

         handleFileObject() {
        this.property.image = this.$refs.file.files[0];
        this.imageName = this.property.image.name;
      }
    }
}
</script>
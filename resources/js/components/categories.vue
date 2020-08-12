<template>
    <div class="p-0">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-bullseye mr-1"></i>
                    Categories
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <button class="btn btn-sm btn-primary" @click="newModal"><i class="fas fa-plus-circle"></i> Add New</button>
                        </li>
                    </ul>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Action</th>
                        <th>Date Posted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in categories" :key="category.id">
                            <td>{{ category.id }}</td>
                            <td>{{ category.name }}</td>
                            <td>{{ category.price | currency }}</td>
                            <td>{{ category.description }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" @click="viewCategory(category)"> <i class="fa fa-eye"></i> View</button>
                                |
                                <button class="btn btn-sm btn-warning" @click="editModal(category)"> <i class="fa fa-edit"></i> Edit</button>
                                <!-- |
                                <button class="btn btn-sm btn-danger" @click="deleteCategory(category.id)"> <i class="fa fa-trash"></i> Delete </button> -->
                            </td>
                            <td>{{ category.created_at |timeAgo }}</td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <loading :loading='loading'></loading>
        </div>
        <div class="modal fade" id="categoryDetail">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <p><b>Name:</b> {{ categ.name }}</p>
                        <p><b>Price:</b> {{ categ.price | currency }}</p>
                        <p><b>Description:</b> {{ categ.description }}</p>
                        <p><b>Last Updated:</b> {{ categ.updated_at | timeAgo }}</p>
                        <p><b>Date Posted:</b> {{ categ.created_at | timeAgo }}</p>
                        <p><b>Image:</b> <br>
                            <img class="img-profile" :src="image(categ.image)" :alt="categ.name + ' Image'">
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addNew">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-show="!editmode">Add Category</h4>
                        <h4 class="modal-title" v-show="editmode">Update Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <label> Name </label>
                                <input v-model="form.name" type="text" name="name" placeholder="Name"
                                    class="form-control" :class="{'is-invaild': form.errors.has('name')}">
                                <has-error :form="form" field="name"></has-error>

                            </div>

                            <div class="form-group">
                                <label> Description </label>
                                <textarea v-model="form.description" name="description" placeholder="Description"
                                    class="form-control" :class="{'is-invaild': form.errors.has('description')}">
                                </textarea>
                                <has-error :form="form" field="description"></has-error>

                            </div>

                            <div class="form-group">
                                <label> Price </label>
                                <input v-model="form.price" type="text" name="price" placeholder="Price"
                                    class="form-control" :class="{'is-invaild': form.errors.has('price')}">
                                <has-error :form="form" field="price"></has-error>

                            </div>

                            <div class="form-group">
                                <label v-show="!editmode">Add Image</label>
                                <label v-show="editmode">Change Image</label>
                                <input type="file" name="photo" class="form-control" @change="addImage">
                            </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">Close</button>
                            <b-button type="submit" variant="primary" class="btn-lg btn-primary" v-if="status" disabled><b-spinner small type="grow"></b-spinner>{{ action }}</b-button>
                            <button type="submit" v-show="editmode" v-if="!status" @click.prevent="editmode ? updateCategory() : createCategory()" class="btn btn-lg btn-success">Update Category</button>
                            <button type="submit" v-show="!editmode" v-if="!status" @click.prevent="editmode ? updateCategory() : createCategory()" class="btn btn-lg btn-primary">Save Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


    export default {
        data(){
            return {
                loading: false,
                action: '',
                status: false,
                categories: [],
                form: new Form({
                    name: '',
                    description: '',
                    image: '',
                    price: '',
                    id: ''
                }),
                editmode: false,
                categ: {}
            }
        },
        methods:{
            editModal: function(category){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(category);
            },

            viewCategory: function(category){
                this.form.reset();
                $('#categoryDetail').modal('show');
                this.categ = category;
            },

            newModal: function(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            image(image){
                let photo = '../uploads/Category/thumbnail/'+image
                return photo;


            },
            emptyform: function(){
                this.form.name= '';
                this.form.description= '';
                this.form.image= '';
            },
            addImage: function(e){
                // console.log('uploading');
                let file = e.target.files[0];
                let reader = new FileReader();
                if(file['size'] < 4223550){
                    reader.onloadend = (file) => {
                        // console.log('RESULT', reader.result)
                        this.form.image = reader.result;
                    }
                    reader.readAsDataURL(file);
                }else{
                    this.form.image = '';
                    swal.fire(
                        "Failed!",
                        "Image Size too large, Greater than 4mb",
                        "error"
                    );
                }

            },
            deleteCategory: function(id){
                swal.fire({
                title: 'Are you sure?',
                text: "Rooms attached to this category will also be removed",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#353535',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    ///send request
                    if (result.value) {

                        this.form.delete('/delete/categories/'+id)
                        .then(()=>{
                            swal.fire(
                                'Deleted!',
                                'Category has been Deleted Successfully.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');
                        })
                        .catch(()=>{
                            swal.fire(
                                "Failed!",
                                "There was something wrong, try again",
                                "warning"
                            );
                        })
                    }

                })
            },
            getCategories(){
                this.loading= true
                this.$Progress.start();
                this.status = true
                axios.get('get/categories').then((response) =>{
                    this.categories = response.data.categories
                    this.status = false
                    this.$Progress.finish();
                    this.loading = false
                }).catch((response)=>{
                    this.status = false
                    this.$Progress.fail();
                    swal.fire(
                        'Error',
                        'Sorry, Cannot load Categories',
                        'error'
                    )
                    this.loading = false

                })
            },

            createCategory(){
                this.status =true
                this.$Progress.start()
                this.action = 'Creating Category'
                this.form.post('post/categories').then((response) =>{
                    this.status = false
                    this.$Progress.start();
                    Fire.$emit('AfterCreate');
                    swal.fire(
                        'Created',
                        'Category has been created',
                        'success'
                    )
                    this.form.reset();
                    $('#addNew').modal('hide');
                }).catch((response) =>{
                    this.status = false
                    this.$Progress.fail();
                    swal.fire(
                        'Error',
                        'Sorry, Cannot Create Categories',
                        'error'
                    )

                })
            },
            updateCategory(){
                this.status =true
                this.$Progress.start()
                this.action = 'Updating Category'
                this.form.put('/put/categories/' +this.form.id).then((response) =>{
                    this.status = false
                    this.$Progress.start();
                    Fire.$emit('AfterCreate');
                    swal.fire(
                        'Updated',
                        'Category has been Updated',
                        'success'
                    )
                    this.form.reset();
                    $('#addNew').modal('hide');
                }).catch((response) =>{
                    this.status = false
                    this.$Progress.fail();
                    swal.fire(
                        'Error',
                        'Sorry, Cannot Edit Categories',
                        'error'
                    )

                })
            }
        },
        created: function(){
            this.getCategories()
            Fire.$on('AfterCreate', ()=>{
                this.getCategories();
            });
        }
    }
</script>

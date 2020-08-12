<template>
    <div class="p-0">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-atom mr-1"></i>
                    {{ display }}
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item mr-1">
                            <button class="btn btn-sm btn-primary" @click="newModal"><i class="fas fa-plus-circle"></i> Add New</button>
                        </li>
                        <li class="nav-item mr-1">
                            <button class="btn btn-sm btn-primary" @click="getRooms"><i class="fas fa-plus-circle"></i> All Rooms</button>
                        </li>
                        <li class="nav-item mr-1">
                            <button class="btn btn-sm btn-primary" @click="getAvailable"><i class="fas fa-atom"></i> View Available</button>
                        </li>
                        <li class="nav-item">
                            <div class="input-group mt-0 input-group-sm" style="width: 350px;">
                                <input type="text" v-model="searchWord" @keyup.enter="search" name="table_search" class="form-control float-right" placeholder="Search for room by room number">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default" @click="search"><i class="fas fa-search"></i></button>
                                </div>
                            </div>    
                        </li>
                    </ul>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Number Number</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Avaliable</th>
                        <th>Action</th>
                        <th>Date Posted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="room in rooms" :key="room.id">
                            <td>{{ room.id }}</td>
                            <td>{{ room.room_number }}</td>
                            <td>{{ room.category.name  }}</td>
                            <td>{{ room.category.price | currency }}</td>
                            <td>{{ room.avaliable }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" @click="viewRoom(room)"> <i class="fa fa-eye"></i> View</button>
                                |
                                <button class="btn btn-sm btn-warning" @click="editModal(room)"> <i class="fa fa-edit"></i> Edit</button>
                                |
                                <button class="btn btn-sm btn-danger" @click="deleteRoom(room.id)"> <i class="fa fa-trash"></i> Delete </button>
                            </td>
                            <td>{{ room.created_at |timeAgo }}</td>

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
                        <p><b>Room Number:</b> {{ categ.room_number }}</p>
                        <p><b>Description:</b> {{ categ.description }}</p>
                        <p><b>Last Updated:</b> {{ categ.updated_at | timeAgo }}</p>
                        <p><b>Date Posted:</b> {{ categ.created_at | timeAgo }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addNew">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-show="!editmode">Add Room</h4>
                        <h4 class="modal-title" v-show="editmode">Update Room</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <label> Room Number </label>
                                <input v-model="form.room_number" type="number" name="room_number" placeholder="Room Number"
                                    class="form-control" :class="{'is-invaild': form.errors.has('room_number')}">
                                <has-error :form="form" field="room_number"></has-error>

                            </div>

                            <div class="form-group">
                                <label> Description </label>
                                <textarea v-model="form.description" name="description" placeholder="Description"
                                    class="form-control" :class="{'is-invaild': form.errors.has('description')}">
                                </textarea>
                                <has-error :form="form" field="description"></has-error>

                            </div>

                            <div class="form-group">
                                <label> Choose Category </label>
                                <b-form-select
                                    v-model="form.category_id"
                                    :options="categories"
                                    value-field="id"
                                    text-field="name"

                                ></b-form-select>
                                <has-error :form="form" field="description"></has-error>

                            </div>



                            <div class="form-group">
                                <label> Room Status </label>
                                <select class="form-control" v-model="form.avaliable">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                                <has-error :form="form" field="avaliable"></has-error>

                            </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">Close</button>
                            <b-button type="submit" variant="primary" class="btn-lg btn-primary" v-if="status" disabled><b-spinner small type="grow"></b-spinner>{{ action }}</b-button>
                            <button type="submit" v-show="editmode" v-if="!status" @click.prevent="editmode ? updateRoom() : createRoom()" class="btn btn-lg btn-success">Update Room</button>
                            <button type="submit" v-show="!editmode" v-if="!status" @click.prevent="editmode ? updateRoom() : createRoom()" class="btn btn-lg btn-primary">Save Room</button>
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
                searchWord: '',
                loading: false,
                action: '',
                status: false,
                rooms: [],
                categories: [],
                form: new Form({
                    room_number: '',
                    category_id: '',
                    description: '',
                    avaliable: '',
                    id: ''
                }),
                editmode: false,
                categ: {},
                display: ''
            }
        },
        methods:{
            editModal: function(category){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(category);
            },

            viewRoom: function(category){
                this.form.reset();
                $('#categoryDetail').modal('show');
                this.categ = category;
            },

            newModal: function(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },

            emptyform: function(){
                this.form.name= '';
                this.form.description= '';
                this.form.image= '';
            },

            deleteRoom: function(id){
                swal.fire({
                title: 'Are you sure?',
                text: "Room will be removed parmanently",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#353535',
                confirmButtonText: 'Yes, Remove it!'
                }).then((result) => {
                    ///send request
                    if (result.value) {

                        this.form.delete('/admin/room/'+id)
                        .then(()=>{
                            swal.fire(
                                'Deleted!',
                                'Room has been Romoved Successfully.',
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
            getRooms(){
                this.loading= true
                this.$Progress.start();
                this.status = true
                axios.get('get/room').then((response) =>{
                    this.rooms = response.data.rooms
                    this.categories = response.data.categories
                    this.status = false
                    this.$Progress.finish();
                    this.loading = false
                    this.display = 'Showing all rooms'
                }).catch((response)=>{
                    this.status = false
                    this.$Progress.fail();
                    swal.fire(
                        'Error',
                        'Sorry, Cannot load Rooms',
                        'error'
                    )
                    this.loading = false
                    this.display = 'Showing all rooms'

                })
            },
            
            getAvailable(){
                this.loading= true
                this.$Progress.start();
                this.status = true
                axios.get('get/room/available').then((response) =>{
                    this.rooms = response.data.rooms
                    this.categories = response.data.categories
                    this.status = false
                    this.$Progress.finish();
                    this.loading = false
                    this.display = 'Showing available rooms'
                }).catch((response)=>{
                    this.status = false
                    this.$Progress.fail();
                    swal.fire(
                        'Error',
                        'Sorry, Cannot load Rooms',
                        'error'
                    )
                    this.loading = false
                    this.display = 'Showing available rooms'

                })
            },

            search(){
                if(this.searchWord){
                    this.loading= true
                    this.$Progress.start();
                    this.status = true
                    axios.get('get/room/search/' + this.searchWord).then((response) =>{
                        this.rooms = response.data.rooms
                        this.categories = response.data.categories
                        this.status = false
                        this.$Progress.finish();
                        this.loading = false
                        this.display = 'Showing Search Results for '+ this.searchWord
                    }).catch((response)=>{
                        this.status = false
                        this.$Progress.fail();
                        swal.fire(
                            'Error',
                            'Sorry, Cannot load Rooms',
                            'error'
                        )
                        this.loading = false
                        this.display = 'Showing Search Results for '+ this.searchWord

                    })
                }else{
                    swal.fire(
                        'Empty',
                        'Sorry, Cannot Perform Search on empty query',
                        'error'
                    )
                }
                
            },

            createRoom(){
                this.status =true
                this.$Progress.start()
                this.action = 'Adding Room'
                this.form.post('post/room').then((response) =>{
                    this.status = false
                    this.$Progress.start();
                    Fire.$emit('AfterCreate');
                    swal.fire(
                        'Added',
                        'Room has been added',
                        'success'
                    )
                    this.form.reset();
                    $('#addNew').modal('hide');
                }).catch((response) =>{
                    this.status = false
                    this.$Progress.fail();
                    swal.fire(
                        'Error',
                        'Sorry, Cannot add Room',
                        'error'
                    )

                })
            },
            updateRoom(){
                this.status =true
                this.$Progress.start()
                this.action = 'Updating Room'
                this.form.put('admin/room/' +this.form.id).then((response) =>{
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
            this.getRooms()
            Fire.$on('AfterCreate', ()=>{
                this.getRooms();
            });
        }
    }
</script>

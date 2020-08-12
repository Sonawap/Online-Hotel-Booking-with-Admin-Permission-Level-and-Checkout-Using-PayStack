<template>
    <div class="p-0">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-users mr-1"></i>
                    {{ display }}
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item mr-1">
                            <button class="btn btn-sm btn-primary" @click="get()"><i class="fas fa-user"></i> All Bookings </button>
                        </li>
                        <li class="nav-item mr-1">
                            <button class="btn btn-sm btn-primary" @click="get()"><i class="fas fa-user-plus"></i> Paid Bookings </button>
                        </li>

                        <li class="nav-item mr-1">
                            <button class="btn btn-sm btn-primary" @click="get()"><i class="fas fa-users"></i> Pending Bookings  </button>
                        </li>

                        <li class="nav-item mr-1">
                            <button class="btn btn-sm btn-primary" @click="get()"><i class="fas fa-users"></i> Unpaid Bookings  </button>
                        </li>

                        <li class="nav-item mr-1">
                            <button class="btn btn-sm btn-primary" @click="get()"><i class="fas fa-users"></i> Past Bookings  </button>
                        </li>

                        <li class="nav-item mr-1">
                            <button class="btn btn-sm btn-primary" @click="newModal"><i class="fas fa-plus-circle"></i> Add New Booking</button>
                        </li>
                        <li class="nav-item">
                            <div class="input-group mt-0 input-group-sm" style="width: 350px;">
                                <input type="text" v-model="searchWord" @keyup.enter="search" name="table_search" class="form-control float-right" placeholder="Search by name, email">

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
                        <th>Booking Number</th>
                        <th>Room Type</th>
                        <th>Name</th>
                        <th>status</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Action</th>
                        <th>Date Posted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="booking in bookings" :key="booking.id">
                            <td>{{ booking.id }}</td>
                            <td>{{ booking.booking_number }}</td>
                            <td>{{ booking.category.name }} - {{ booking.category.price | currency }}</td>
                            <td>{{ booking.name  }}</td>
                            <td>{{ booking.paid  }}</td>
                            <td>{{ booking.check_in_at | myDate }}</td>
                            <td>{{ booking.check_out_at | myDate }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" @click="view(booking)"> <i class="fa fa-eye"></i> View</button>
                                |
                                <button class="btn btn-sm btn-warning" @click="editModal(booking)"> <i class="fa fa-edit"></i> Edit</button>
                                <!-- |
                                <button class="btn btn-sm btn-danger" @click="deletes(user.id)"> <i class="fa fa-trash"></i> Delete </button> -->
                            </td>
                            <td>{{ booking.created_at |timeAgo }}</td>

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
                        <p><b>ID: </b>{{ catego.id }}</p>
                        <p><b>Booking Number: </b>{{ catego.booking_number }}</p>
                        <p><b>Name: </b>{{ catego.name  }}</p>
                        <p><b>Status: </b>{{ catego.paid  }}</p>
                        <p><b>Description: </b>{{ catego.description  }}</p>
                        <p><b>Address: </b>{{ catego.address  }}</p>
                        <p><b>Check In: </b> {{ catego.check_in_at | myDate }}</p>
                        <p><b>Check Out: </b> {{ catego.check_out_at | myDate }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addNew">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-show="!editmode">Add Booking</h4>
                        <h4 class="modal-title" v-show="editmode">Update Booking</h4>
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
                                <label> Email </label>
                                <input v-model="form.email" type="text" name="email" placeholder="Email"
                                    class="form-control" :class="{'is-invaild': form.errors.has('email')}">
                                <has-error :form="form" field="email"></has-error>
                            </div>

                            <div class="form-group">
                                <label> Phone Number </label>
                                <input v-model="form.phone" type="text" name="phone" placeholder="Phone Number"
                                    class="form-control" :class="{'is-invaild': form.errors.has('phone')}">
                                <has-error :form="form" field="phone"></has-error>
                            </div>

                            <div class="form-group">
                                <label> Choose Room Type </label>
                                <b-form-select
                                    v-model="form.category_id"
                                    :options="categories"
                                    text-field="name"
                                    value-field="id"

                                ></b-form-select>
                                <has-error :form="form" field="category_id"></has-error>

                            </div>

                            <div class="form-group">
                                <label> Addition Infomation </label>
                                <textarea v-model="form.description" name="description" placeholder="Additional Infomation"
                                    class="form-control" :class="{'is-invaild': form.errors.has('description')}">
                                </textarea>
                                <has-error :form="form" field="description"></has-error>

                            </div>

                            <div class="form-group">
                                <label> Address </label>
                                <textarea v-model="form.address" name="address" placeholder="Your Address"
                                    class="form-control" :class="{'is-invaild': form.errors.has('address')}">
                                </textarea>
                                <has-error :form="form" field="address"></has-error>
                            </div>

                            <div class="form-group">
                                <label> Check In </label>
                                    <b-calendar v-model="form.check_in_at"  locale="en-US"></b-calendar>
                                <has-error :form="form" field="check_in_at"></has-error>
                            </div>
                            <div class="form-group">
                                <label> Check Out </label>
                                    <b-calendar v-model="form.check_out_at"  locale="en-US"></b-calendar>
                                <has-error :form="form" field="check_out_at"></has-error>
                            </div>



                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">Close</button>
                            <b-button type="submit" variant="primary" class="btn-lg btn-primary" v-if="status" disabled><b-spinner small type="grow"></b-spinner>{{ action }}</b-button>
                            <button type="submit" v-show="editmode" v-if="!status" @click.prevent="editmode ? update() : create()" class="btn btn-lg btn-success">Update Booking</button>
                            <button type="submit" v-show="!editmode" v-if="!status" @click.prevent="editmode ? update() : create()" class="btn btn-lg btn-primary">Save Booking</button>
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
                bookings: [],
                categories: [],
                form: new Form({
                    name: '',
                    email: '',
                    check_out_at: '',
                    address: '',
                    check_in_at: '',
                    category_id: '',
                    phone: '',
                    description: '',
                    id: ''
                }),
                editmode: false,
                catego: {},
                display:'',
                searchWord: '',
            }
        },
        methods:{
            editModal: function(category){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(category);
            },

            view: function(booking){
                this.form.reset();
                $('#categoryDetail').modal('show');
                this.catego = booking;
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

            deletes: function(id){
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
            get(){
                this.loading= true
                this.$Progress.start();
                this.status = true
                axios.get('get/booking').then((response) =>{
                    this.bookings = response.data.bookings
                    this.categories = response.data.categories
                    this.status = false
                    this.$Progress.finish();
                    this.loading = false
                    this.display = 'Currently showing all Bookings'
                }).catch((response)=>{
                    this.status = false
                    this.$Progress.fail();
                    swal.fire(
                        'Error',
                        'Sorry, Cannot load Bookings',
                        'error'
                    )
                    this.loading = false
                    this.display = 'Currently showing all Bookings'

                })
            },

            getCustomer(){
                this.loading= true
                this.$Progress.start();
                this.status = true
                axios.get('get/user/customer').then((response) =>{
                    this.users = response.data.users
                    this.roles = response.data.roles
                    this.status = false
                    this.$Progress.finish();
                    this.loading = false
                    this.display = 'Currently showing all customers'
                }).catch((response)=>{
                    this.status = false
                    this.$Progress.fail();
                    swal.fire(
                        'Error',
                        'Sorry, Cannot load Customers',
                        'error'
                    )
                    this.loading = false
                    this.display = 'Currently showing all customers'

                })
            },

            getAdmin(){
                this.loading= true
                this.$Progress.start();
                this.status = true
                axios.get('get/user/admin').then((response) =>{
                    this.users = response.data.users
                    this.roles = response.data.roles
                    this.status = false
                    this.$Progress.finish();
                    this.loading = false
                    this.display = 'Currently showing all Admins'
                }).catch((response)=>{
                    this.status = false
                    this.$Progress.fail();
                    swal.fire(
                        'Error',
                        'Sorry, Cannot load admins',
                        'error'
                    )
                    this.loading = false
                    this.display = 'Currently showing all Admins'

                })
            },

            create(){
                this.status =true
                this.$Progress.start()
                this.action = 'Creating Booking'
                this.form.post('booking').then((response) =>{
                    this.status = false
                    this.$Progress.start();
                    Fire.$emit('AfterCreate');
                    swal.fire(
                        'Created',
                        'Booking has been created',
                        'success'
                    )
                    this.form.reset();
                    $('#addNew').modal('hide');
                }).catch((response) =>{
                    this.status = false
                    this.$Progress.fail();
                    swal.fire(
                        'Error',
                        'Sorry, Cannot Create Booking',
                        'error'
                    )

                })
            },
            search(){
                if(this.searchWord){
                    this.loading= true
                    this.$Progress.start();
                    this.status = true
                    axios.get('get/user/search/' + this.searchWord).then((response) =>{
                        this.users = response.data.users
                        this.roles = response.data.roles
                        this.status = false
                        this.$Progress.finish();
                        this.loading = false
                        this.display = 'Showing Search result for ' + this.searchWord
                    }).catch((response)=>{
                        this.status = false
                        this.$Progress.fail();
                        swal.fire(
                            'Error',
                            'Sorry, Cannot Find User',
                            'error'
                        )
                        this.loading = false
                        this.display = 'Showing Search result for ' + this.seachWord

                    })
                }else{
                    swal.fire(
                        'Empty',
                        'Sorry, Cannot Perform Search on empty query',
                        'error'
                    )
                }
                
            },
            update(){
                this.status =true
                this.$Progress.start()
                this.action = 'Updating User Info'
                this.form.put('user/' +this.form.id).then((response) =>{
                    this.status = false
                    this.$Progress.start();
                    Fire.$emit('AfterCreate');
                    swal.fire(
                        'Updated',
                        'User Info has been Updated',
                        'success'
                    )
                    this.form.reset();
                    $('#addNew').modal('hide');
                }).catch((response) =>{
                    this.status = false
                    this.$Progress.fail();
                    swal.fire(
                        'Error',
                        'Sorry, Cannot Update User Info',
                        'error'
                    )

                })
            }
        },
        created: function(){
            this.get()
            Fire.$on('AfterCreate', ()=>{
                this.get();
            });
        }
    }
</script>

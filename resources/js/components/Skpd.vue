<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Skpd List</h3>

                            <div class="card-tools">

                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                    data-target="#addProduct">
                                    <i class="fa fa-plus-square"></i>
                                    Add New
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Short Name</th>
                                        <!-- <th>Photo</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="skpd in skpds.data" :key="skpd.id">

                                        <td>{{skpd.id}}</td>
                                        <td>{{skpd.name}}</td>
                                        <td>{{skpd.short_name | truncate(30, '...')}}</td>
                                        <td>
                                                                                    <a href="#" @click="editModal(skpd)">
                                            <i class="fa fa-edit blue"></i>
                                        </a>
                                        /
                                        <a href="#" @click="deleteSkpd(skpd.id)">
                                            <i class="fa fa-trash red"></i>
                                        </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Create New Skpd</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form @submit.prevent="editmode ? updateSkpd() : createSkpd()">
                            <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Short Name</label>
                            <input v-model="form.short_name" type="text" name="short_name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('short_name') }">
                            <has-error :form="form" field="short_name"></has-error>
                        </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
  import VueTagsInput from '@johmun/vue-tags-input';

    export default {
      components: {
          VueTagsInput,
        },
        data () {
            return {
                editmode: false,
                skpds : {},
                form: new Form({
                    id : '',
                    name: '',
                    short_name: '',
                }),
                autocompleteItems: [],
            }
        },
        methods: {

          getResults(page = 1) {

              this.$Progress.start();
              
              axios.get('api/skpd?page=' + page).then(({ data }) => (this.skpds = data.data));

              this.$Progress.finish();
          },
          loadSkpds(){

            // if(this.$gate.isAdmin()){
              axios.get("api/skpd").then(({ data }) => (this.skpds = data.data));
            // }
          },

          editModal(skpd){
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(skpd);
          },
          newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },
          createSkpd(){
              this.$Progress.start();

              this.form.post('api/skpd')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadSkpds();

                } else {
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });

                  this.$Progress.failed();
                }
              })
              .catch(()=>{

                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
              })
          },
          updateSkpd(){
              this.$Progress.start();
              this.form.put('api/skpd/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');

                  this.loadSkpds();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },
          deleteSkpd(id){
              Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {

                      // Send request to the server
                        if (result.value) {
                              this.form.delete('api/skpd/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your file has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadSkpds();
                              }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                        }
                  })
          },

        },
        mounted() {
            
        },
        created() {
            this.$Progress.start();

            this.loadSkpds();

            this.$Progress.finish();
        },
        filters: {
            truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
        },
        computed: {
          filteredItems() {
            return this.autocompleteItems.filter(i => {
              return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
          },
        },
    }




    // export default {
    //     data () {
    //         return {
    //             editmode: false,
    //             skpds : {},
    //             form: new Form({
    //                 id : '',
    //                 name : '',
    //                 short_name: '',
    //             }),

    //             autocompleteItems: [],
    //         }
    //     },
    //     methods: {

    //         loadSkpds() {
    //             // if(this.$gate.isAdmin()){
    //             axios.get("api/skpd").then(({
    //                 data
    //             }) => (this.skpds = data.data));
    //             // }
    //         },

    //         editModal(skpd) {
    //             this.editmode = true;
    //             this.form.reset();
    //             $('#addNew').modal('show');
    //             this.form.fill(skpd);
    //         },
    //         newModal() {
    //             this.editmode = false;
    //             this.form.reset();
    //             $('#addNew').modal('show');
    //         },

    //         createSkpd() {
    //             this.$Progress.start();

    //             this.form.post('api/skpd')
    //                 .then((data) => {
    //                     $('#addNew').modal('hide');

    //                     Toast.fire({
    //                         icon: 'success',
    //                         title: data.data.message
    //                     });
    //                     this.$Progress.finish();
    //                     this.loadSkpds();

    //                 })
    //                 .catch(() => {

    //                     Toast.fire({
    //                         icon: 'error',
    //                         title: 'Some error occured! Please try again'
    //                     });
    //                 })
    //         },
    //         updateSkpd() {
    //             this.$Progress.start();
    //             this.form.put('api/skpd/' + this.form.id)
    //                 .then((response) => {
    //                     // success
    //                     $('#addNew').modal('hide');
    //                     Toast.fire({
    //                         icon: 'success',
    //                         title: response.data.message
    //                     });
    //                     this.$Progress.finish();
    //                     //  Fire.$emit('AfterCreate');

    //                     this.loadSkpds();
    //                 })
    //                 .catch(() => {
    //                     this.$Progress.fail();
    //                 });

    //         },
    //         deleteSkpd(id) {
    //             Swal.fire({
    //                 title: 'Are you sure?',
    //                 text: "You won't be able to revert this!",
    //                 showCancelButton: true,
    //                 confirmButtonColor: '#d33',
    //                 cancelButtonColor: '#3085d6',
    //                 confirmButtonText: 'Yes, delete it!'
    //             }).then((result) => {

    //                 // Send request to the server
    //                 if (result.value) {
    //                     this.form.delete('api/skpd/' + id).then(() => {
    //                         Swal.fire(
    //                             'Deleted!',
    //                             'Your file has been deleted.',
    //                             'success'
    //                         );
    //                         // Fire.$emit('AfterCreate');
    //                         this.loadskpds();
    //                     }).catch((data) => {
    //                         Swal.fire("Failed!", data.message, "warning");
    //                     });
    //                 }
    //             })
    //         },

    //     },
    //     mounted() {

    //     },
    //     created() {
    //         this.$Progress.start();

    //         this.loadSkpds();

    //         this.$Progress.finish();
    //     },
    //             filters: {
    //         truncate: function (text, length, suffix) {
    //             return text.substring(0, length) + suffix;
    //         },
    //     },
    //     computed: {
    //       filteredItems() {
    //         return this.autocompleteItems.filter(i => {
    //           return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
    //         });
    //       },
    //     },
    // }

</script>

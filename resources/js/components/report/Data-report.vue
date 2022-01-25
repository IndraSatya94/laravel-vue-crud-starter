<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Report List</h3>

                            <div class="card-tools">

                                <button type="button" class="btn btn-sm btn-primary">
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
                                        <th>Subject</th>
                                        <th>Description</th>
                                        <th>Report Status</th>
                                        <th>Report Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in reports.data" :key="item.id">

                                        <td>{{item.id}}</td>
                                        <td>{{item.subject}}</td>
                                        <td>{{item.description}}</td>
                                        <td>{{item.reportstatus.name}}</td>
                                        <!-- <td>{{item.ReportType.name}}</td> -->

                                        <td>
                                            <a href="">edit</a>
                                            <a href="">delete</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">

                        </div>
                    </div>
                    <!-- /.card -->
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
                reports : {},
                form: new Form({
                    id : '',
                    reportstatus : '',
                    subject: '',
                    description: '',
                    reportstatus_id: '',
                }),
                reportstatus: [],
              
                tag:  '',
                autocompleteItems: [],
            }
        },
        methods: {

          getResults(page = 1) {

              this.$Progress.start();
              
              axios.get('api/report?page=' + page).then(({ data }) => (this.reports = data.data));

              this.$Progress.finish();
          },
          loadReports(){

            // if(this.$gate.isAdmin()){
              axios.get("api/report").then(({ data }) => (this.reports = data.data));
            // }
          },
          loadReportStatus(){
              axios.get("/api/reportstatus/list").then(({ data }) => (this.reportstatus = data.data));
          },

          editModal(report){
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(report);
          },
          newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },
          createReport(){
              this.$Progress.start();

              this.form.post('api/report')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadReports();

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
          updateReport(){
              this.$Progress.start();
              this.form.put('api/report/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');

                  this.loadReports();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },
          deleteReport(id){
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
                              this.form.delete('api/report/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your file has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadReports();
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

            this.loadReports();
            this.loadReportStatus();

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
</script>

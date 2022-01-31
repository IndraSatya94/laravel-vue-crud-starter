<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Report List</h3>

                            <div class="card-tools">

                                <button type="button" class="btn btn-sm btn-primary" @click="newModal">
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
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>Subject</th>
                                        <th>Description</th>
                                        <th>Report Status</th>
                                        <th>Report Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="report,index in reports.data" :key="report.id">

                                        <td>{{++index}}</td>
                                        <td>{{report.id}}</td>
                                        <td>{{report.subject}}</td>
                                        <td>{{report.description}}</td>
                                        <td>{{report.reportstatus.name}}</td>
                                        <td>{{report.reporttype.name}}</td>
                                        <!-- <td>{{item.ReportType.name}}</td> -->

                                        <td>
                                            <a href="#" @click="editModal(report)">
                                                <i class="fa fa-edit blue"></i>
                                            </a>
                                            /
                                            <a href="#" @click="deleteReport(report.id)">
                                                <i class="fa fa-trash red"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <pagination :data="reports" @pagination-change-page="getResults"></pagination>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editmode">Create New Product</h5>
                            <h5 class="modal-title" v-show="editmode">Edit Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form @submit.prevent="editmode ? updateReport() : createReport()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Subject</label>
                                    <input v-model="form.subject" type="text" name="subject" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('subject') }">
                                    <has-error :form="form" field="subject"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <input v-model="form.description" type="text" name="description"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                                    <has-error :form="form" field="description"></has-error>
                                </div>

                                <div class="form-group">

                                    <label>Report Status</label>
                                    <select class="form-control" v-model="form.reportstatus_id">
                                        <option v-for="(cat,index) in reportstatuses" :key="index" :value="index"
                                            :selected="index == form.reportstatus_id">{{ cat }}</option>
                                    </select>
                                    <has-error :form="form" field="reportstatus_id"></has-error>
                                </div>

                                <div class="form-group">

                                    <label>Report Type</label>
                                    <select class="form-control" v-model="form.reporttype_id">
                                        <option v-for="(type,index) in reporttypes" :key="index" :value="index"
                                            :selected="index == form.reporttype_id">{{ type }}</option>
                                    </select>
                                    <has-error :form="form" field="reporttype_id"></has-error>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
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
        data() {
            return {
                editmode: false,
                reports: {},
                form: new Form({
                    id: '',
                    reportstatus: '',
                    reporttype: '',
                    name: '',
                    subject: '',
                    description: '',
                    reportstatus_id: '',
                    reporttype_id: '',
                }),
                reportstatuses: [],
                reporttypes: [],

                autocompleteItems: [],
            }
        },
        methods: {

            getResults(page = 1) {

                this.$Progress.start();

                axios.get('api/report?page=' + page).then(({
                    data
                }) => (this.reports = data.data));

                this.$Progress.finish();
            },
            loadReports() {

                // if(this.$gate.isAdmin()){
                axios.get("api/report").then(({
                    data
                }) => (this.reports = data.data));
                // }
            },
            loadReportStatuses() {
                axios.get("/api/reportstatus/list").then(({
                    data
                }) => (this.reportstatuses = data.data));
            },
            loadReportTypes() {
                axios.get("/api/reporttype/list").then(({
                    data
                }) => (this.reporttypes = data.data));
            },

            editModal(report) {
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(report);
            },
            newModal() {
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            createReport() {
                this.$Progress.start();

                this.form.post('api/report')
                    .then((data) => {
                        if (data.data.success) {
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
                    .catch(() => {

                        Toast.fire({
                            icon: 'error',
                            title: 'Some error occured! Please try again'
                        });
                    })
            },
            updateReport() {
                this.$Progress.start();
                this.form.put('api/report/' + this.form.id)
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
            deleteReport(id) {
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
                        this.form.delete('api/report/' + id).then(() => {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            // Fire.$emit('AfterCreate');
                            this.loadReports();
                        }).catch((data) => {
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
            this.loadReportStatuses();
            this.loadReportTypes();

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

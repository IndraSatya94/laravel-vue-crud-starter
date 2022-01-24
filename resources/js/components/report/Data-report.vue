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
                                    <tr v-for="item in report" :key="item.id">

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
    export default {
        data: function () {
            return {
                report: {},
                form: new Form({
                    id: '',
                    subject: '',
                    description: '',
                    reportstatus_id: '',
                    name: '',
                }),
                reportstatus: [],
            }
        },

        methods: {
            loadReportstatuses() {
                axios.get('/api/reportstatus/list').then(response => {
                        this.report = response.data;

                    })
                    .catch(error => {
                        console.log(error.response.data);
                    });
            },
            loadReports() {
                axios.get('/api/report').then(response => {
                        this.report = response.data;

                    })
                    .catch(error => {
                        console.log(error.response.data);
                    });
            }
        },

        created() {
            this.loadReports();
            this.loadReportstatuses();
        }
    };

</script>

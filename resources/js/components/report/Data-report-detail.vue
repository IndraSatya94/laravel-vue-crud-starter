<template>
 <section class="content">
            <div class="container-fluid">
                <!-- /.col -->
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Detail Report</h3>

                            <div class="card-tools">
                                <a href="#" class="btn btn-tool" data-toggle="tooltip" title="Previous"><i
                                        class="fas fa-chevron-left"></i></a>
                                <a href="#" class="btn btn-tool" data-toggle="tooltip" title="Next"><i
                                        class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="mailbox-read-info">
                                <h5 style="font-weight: 400;">...</h5>
                                <h6 style="font-weight: 400;">From: ...
                                    <span class="mailbox-read-time float-right">...</span></h6>
                            </div>

                            <!-- /.mailbox-controls -->
                            <div class="mailbox-read-message">
                                <!-- <p>{!! nl2br(e($reports->description)) !!}</p> -->
                            </div>
                            <!-- /.mailbox-read-message -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer bg-white">
                            <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                <li>
                                    <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>

                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i>
                                            Sep2014-report.pdf</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>1,245 KB</span>
                                            <a href="#" class="btn btn-default btn-sm float-right"><i
                                                    class="fas fa-cloud-download-alt"></i></a>
                                        </span>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <!-- /.card-footer -->
                        <div class="card-footer">
                            <div class="float-right">

                                <button type="button" class="btn btn-primary"><i class="fas fa-share"></i> Teruskan ke
                                    network support</button>
                            </div>
                            <!-- <button type="button" class="btn btn-default" onClick="Delete(this.id)" id="{{ $reports->id }}"><i class="far fa-trash-alt"></i> Delete</button> -->

                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

        </section>
        <!-- /.content -->
</template>

<script>

</script>
<style>
    iframe {
        max-width: 200px;
        max-height: 150px;
    }

    #add_event_checklist textarea {
        width: 100%;
        height: 120px;
        padding: 10px;
    }

    .btn-primary {
        background-color: black;
        border-color: black;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #3c8dbc;
        border-color: #367fa9;
        padding: 1px 10px;
        color: #fff;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        margin-right: 5px;
        color: rgba(255, 255, 255, 0.7);
    }
</style>

<?php if ($this->session->userdata("user_type") != 2) { ?>
    <script>
        location.href = "<?= base_url() ?>";
    </script>
<?php } ?>

<script>
    selectedlink = 'managechecklist';
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Pre Event Checklist
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url() ?>dashboard/">Dashboard</a></li>
            <li class="active">Pre Event Checklist</li>
        </ol>
    </section>

    <?php
    $user = '';
    $code = '';
    $id = '';

    if (isset($videosembed) && $videosembed != "") {
        foreach ($videosembed as $workouts) {
            $user = $workouts['user_id'];
            $code = $workouts['code'];
            $id = $workouts['id'];
        } 
    }
    ?>
 
    <!-- Main content -->
    <section class="content">
        <div class="container box">
            <form method="post" id="add_event_checklist" enctype="multipart/form-data">
                <div class="form-group"><br /><br />
                    <label>Select User</label>
                    <select class="form-control select2" id="userids" name="user_id[]" multiple data-placeholder="Select User" style="width: 100%;">
                        <?php
                        foreach ($userlist as $users) {
                            $sel = '';
                            if ($user == $users['id'])
                                $sel = 'selected = "selected"';
                            echo "<option value='" . $users['id'] . "' " . $sel . ">" . $users['username'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Embeded Code</label>
                    <textarea name="code" id="code" placeholder="Please add your embeded code here"><?php echo $code; ?></textarea>
                </div>
                <?php if ($id != "") { ?>
                    <input type="hidden" name='id' id="embed_combine_id" value='<?php echo $id; ?>'>
                    <button type="submit" name="add_combine" class="btn btn-primary" id="add_combine">Update</button>
                <?php } else { ?>
                    <button type="submit" name="add_combine" class="btn btn-primary" id="add_combine">Save</button>
                <?php } ?>

            </form>
            <br />



            <div>
                <h3 align="center">Pre Event Checklist</h3>
                <div class="table-responsive">
                    <table id="orig_scores_data" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>User</th>
                                <th>Embeded Code</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (isset($result) && !empty($result)) { ?>
                                <?php $i = 1; ?>
                                <?php foreach ($result as $key => $row) { ?>
                                    <tr>
                                        <td><?php echo $i ?> </td>
                                        <td><?php echo $row->first_name . ' ' . $row->last_name ?></td>
                                        <td><?php echo $row->code ?></td>
                                        <td><?php echo DateFormat($row->created_date) ?></td>
                                        <td><a href="<?php echo base_url('pre_event/manage_checklist') ?>?id=<?php echo $row->id ?>">Edit</a> <a href="<?php echo base_url('delete/pre_events/id/' . $row->id) ?>">Delete</a></td>
                                    </tr>
                                    <?php $i++ ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>



                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
    </section>


    <!-- /.content -->
    <div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<!----Loader--->
 





<!-- /.content-wrapper -->
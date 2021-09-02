  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Category
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Category</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="col-xs-6">
                <!-- <h3 class="box-title">Category List</h3> -->
              </div>
              <div class="col-xs-6 text-right">
              <a href="javascript:void(0)" class="btn btn-info btn-flat add-category"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</a>
              </div>
            </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="category-table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Category Name</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
          </div>
            <!-- /.box -->  
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<div class="modal fade" id="modal-category">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <form id="form-category" enctype="multipart/form-data">
        <input type="hidden" name="form-action" id="form-action">
        <input type="hidden" name="cat-id" id="cat-id">
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label for="category-name">Category Name</label>
              <input type="text" class="form-control" name="category-name" id="category-name" placeholder="Enter Category">
            </div>
            <div class="form-group col-md-6">
              <label for="category-image">Category Image</label>
              <input type="file" id="category-image" name="category-image" accept="image/*">
              <p class="help-block">Please upload less than 2 Mb</p>
            </div>
            <div class="form-group col-md-6" id="blah_div" style="display: none;height: auto;">
              <a class="btn btn-app">
                <span class="badge bg-red">3</span>
                <img id="blah" src="#" alt="your image" width="150" />
              </a>
              
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
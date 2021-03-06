@extends('layouts.admin.header')

@section('header')

{!!Html::script('assets/global/plugins/jstree/dist/jstree.min.js'); !!}

<script>
  jQuery(document).ready(function() {

    function customMenu(node) {
      // The default set of all items
      var tree = $("#category_tree").jstree(true);
      var items = {
        "createItem": {
          "label": "Add",
          "action": function () {
            window.location.href="category/add";
          }
        },
        "deleteItem": { // The "delete" menu item
          "label": "Delete",
          "action": function () {
            $('#delete_modal').modal({
              backdrop: 'static',
              keyboard: false
            })
            .one('click', '.delete', function(e) {
              $.ajax({
                url: 'category/delete_ajax/' + node.id,
                success: function( res ) {
                  if(res['success'] == true) {
                      toastr['success']("Category Deleted Successfully!", "Success");
                      tree.delete_node(node);
                  } else {
                      toastr['warning']("Category not Deleted Successfully!", "Warning")
                  }
                }
            });
            });
          }
        },
        "editItem" : {
          "label": "Edit",
          "action": function () {
            window.location.href="category/" + node.id;
          }
        }

      };
      return items;
  }

    $('#category_tree').jstree({
      'plugins': ["contextmenu","wholerow", "dnd", "state","types"],
      'core': {
        "themes" : {
            "responsive": true
        },
        "check_callback" : true,
        'data': <?php echo json_encode($categories)?>,
      },
      'contextmenu': {
        'items': customMenu
      },
      'types': {
        "default" : {
            "icon" : "fa fa-th-list icon-state-warning icon-lg"
        }
      }
    });

    $('.page-sidebar-menu .active').removeClass('active');
    $('.page-sidebar-menu .categories').addClass('active');
    $('.page-sidebar-menu .categories .categories_list').addClass('active');
  });
</script>

@endsection

@section('content')
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
  <div class="page-content">
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Modal title</h4>
          </div>
          <div class="modal-body">
             Widget settings form goes here
          </div>
          <div class="modal-footer">
            <button type="button" class="btn blue">Save changes</button>
            <button type="button" class="btn default" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <!-- BEGIN PAGE HEADER-->
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="index.html">Admin</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">Category</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">List</a>
        </li>
      </ul>
    </div>
    <!-- END PAGE HEADER-->
    <div class="row">
      <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet box green-haze">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-globe"></i>Categories
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse">
                </a>
                <a href="#portlet-config" data-toggle="modal" class="config">
                </a>
                <a href="javascript:;" class="reload">
                </a>
                <a href="javascript:;" class="remove">
                </a>
              </div>
            </div>
            <div class="portlet-body">
              <div id='category_tree'>
              </div>
            </div>
          </div>
        <!-- END EXAMPLE TABLE PORTLET-->
      </div>
    </div>
  </div>
  <div id="delete_modal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" data-attention-animation="false">
    <div class="modal-body">
      <p>
         Would you like to delete this category?
      </p>
    </div>
    <div class="modal-footer">
      <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
      <button type="button" data-dismiss="modal" class="btn blue delete">OK</button>
    </div>
  </div>
</div>

<!-- END CONTENT -->
@endsection
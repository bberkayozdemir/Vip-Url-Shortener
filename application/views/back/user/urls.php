<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Urls</h1>      
</div>

<div class="urltable">

    <div class="row urltable-top">
        <div class="col-xl-2 col-md-4">
            <a href="<?=base_url()?>user" class="btn btn-primary" id="urltable-create">Create</a>
        </div>
        <div class="col-xl-8 col-md-4"></div>
        <div class="col-xl-2 col-md-4">
            <form method="POST" action="" id="search-url">
                <div class="input-group urls-search">
                  <input placeholder="Search Urls" type="text" class="form-control" aria-label="Search">
                  <div class="input-group-append">
                    <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                  </div>
                </div>
             </form>

        </div>
    </div>

    <div class="urltable-content">

        

    </div>

</div>

<div class="modal" tabindex="-1" role="dialog" id="edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Url</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="edit-modal-content"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="edit-save">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="delete-modal" style="top:15%">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Are you sure?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="delete-modal-content">
            You are about to delete this item are you sure
            <input type="hidden" name="delete-id"/>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="delete-yes">Yes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
    
    $(document).ready(function () {

        $(".urltable-content").load("<?=base_url()?>user/url_list");

        $("#urltable-create").click(function(e){
            e.preventDefault();
            $("#nav a[data-title='Dashboard']").click();
        });

        $(".urltable-content").on("click", "a[data-action]", function(e){
            e.preventDefault();
            
            if ($(this).attr("data-action") == "view"){
                var url = $(this).attr("href");
                window.history.pushState("", "", url);
                set_page(url);
                $("#nav").find("a").removeClass("active");
            }else if ($(this).attr("data-action") == "edit"){
                
                $.ajax({
                    url: '<?=base_url()?>user/urls/' + $(this).parent().attr("data-id") + "/edit",
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $("#edit-modal-content").html(loading_set_np);
                        $("#edit-modal").modal();
                    },
                    success: function( data){
                        $("#edit-modal-content").html(data);
                    },
                    error: function( e ){
                        console.log( e );
                    }
                });
                
            }else if ($(this).attr("data-action") == "delete"){
                $("#delete-modal").modal();
                $("input[name='delete-id']").attr("value", $(this).parent().attr("data-id"));
            }else if ($(this).attr("data-action") == "copy"){

                copyToClipboard($(this).parent().attr("data-url"));
                $.notify("Copied to Clipboard", "success");

            }else if ($(this).attr("data-action") == "status"){
                
                var status = $(this).attr("data-status");
                var selector = $(this);

                $.ajax({
                    url: '<?=base_url()?>user/urls/' + $(this).parent().attr("data-id") + "/update-status",
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        if (status == "1")
                            $.notify("Disabling", "info");
                        else
                            $.notify("Enabling", "info");
                    },
                    success: function( data){

                        if (data == "success")
                        {
                            if (status == "1"){
                                $.notify("Disabled successfully", "success");
                                selector.attr("data-status", "0");
                                selector.attr("title", "Enable Url");
                                selector.parent().siblings(".urlbox-status").find("div").html("Disabled");
                            }
                            else{
                                $.notify("Enabled successfully", "success");
                                selector.attr("data-status", "1");
                                selector.attr("title", "Disable Url");
                                selector.parent().siblings(".urlbox-status").find("div").html("Enabled");
                            }
                            
                            //$("#nav a[data-title='Urls']").click();
                        }else
                            $.notify("Unknown error", "error");
                    },
                    error: function( e ){
                        console.log( e );
                    }
                });
            }
        });
        
        $("#delete-yes").click(function(){
            $.ajax({
                url: '<?=base_url()?>user/urls/' + $("input[name='delete-id']").attr("value") + "/delete",
                contentType: false,
                processData: false,
                success: function( data){
                    
                    $('#delete-modal').modal('hide');
                    if (data == "success")
                    {
                        $.notify("Deleted successfully", "success");
                        $("#nav a[data-title='Urls']").click();
                    }else
                        $.notify("Error while deleting", "error");
                    
                    $("input[name='delete-id']").attr("value","");
                },
                error: function( e ){
                    console.log( e );
                    $.notify("Error while deleting", "error");
                    $("input[name='delete-id']").attr("value","");
                }
            });
        });
        
        $("#edit-modal").on("click", "#edit-advanced",function(e){
            e.preventDefault();
            $(".advanced-options-url-edit").slideToggle("fast");
        });
        
        $("#edit-save").click(function(){
            $("#url-edit-form").submit();
        });
        
        $("#edit-modal").on("submit", "#url-edit-form",function(e){
            e.preventDefault();
            
            var url = ($("#url-edit-form").find("input[name='url']").val()).trim();

            if (url == "")
            {
                $.notify("Please fill the url input", "error");
                return;
            }

            var form_data = new FormData($(this)[0]);

            $.ajax({
                url: $(this).attr("action"),
                type: 'post',
                data: form_data,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $("#edit-save").text("Loading...");
                    $("#edit-save").attr("disabled", "");
                },
                success: function( data){
                    $("#edit-save").removeAttr("disabled");
                    $("#edit-save").text("Save changes");
                    process_output_data_edit(data);
                },
                error: function( e ){
                    $("#edit-save").text("Save changes");
                    $("#edit-save").removeAttr("disabled");
                    console.log( e );
                }
            });
        });

        $(".urltable-content").on("click", ".urltable-pagination a",function(e){
            e.preventDefault();
            
            if ($(this).attr("page") != "active")
            {
                var q = $(this).attr("search");
                if (typeof q !== typeof undefined && q !== false)
                    $(".urltable-content").load("<?=base_url()?>user/url_list/" + $(this).attr("page") + "/" + $(this).attr("search"));
                else
                    $(".urltable-content").load("<?=base_url()?>user/url_list/" + $(this).attr("page"));
            }
        });

        $("#search-url").submit(function(e){
            e.preventDefault();

            $(".urltable-content").load("<?=base_url()?>user/url_list/1/"+$("#search-url input").val());
        });
    });
    
    function process_output_data_edit(data)
    {
        if (data == "success"){
            $.notify("Changes saved", "success");
            $('#edit-modal').modal('hide');
            $("#nav a[data-title='Urls']").click();
        }else if (data == "error" || data == "no_data"){
            $.notify("Unknown error happened", "error");
        }else if (data == "name_exists"){
            $.notify("This alias is already used by another link please use different one", "error");
        }else if (data == "bad_url" || data == "no_url"){
            $.notify("Please enter a correct url", "error");
        }else if (data == "bad_alias"){
            $.notify("You have invalid characters in your custom alias!", "error");
        }else if (data == "bad_url_loc"){
            $.notify("Please enter a correct url on location targeting", "error");
            $(".btn-submit").text("Shorten");
        }else if (data == "bad_url_device"){
            $.notify("Please enter a correct url on device targeting", "error");
            $(".btn-submit").text("Shorten");
        }else{
            $.notify("Unknown error happened", "error");
        }
    }
    
</script>

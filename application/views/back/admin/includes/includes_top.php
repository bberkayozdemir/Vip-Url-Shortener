<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Admin Panel <?php if (isset($page_title)){?>- <?=$page_title?> <?php } ?></title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="<?=base_url()?>src/css/panel_style.css" rel="stylesheet"/>
    <link href="<?=base_url()?>src/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?=base_url()?>src/css/bootstrap-toggle.min.css" rel="stylesheet"/>
    <link href="<?=base_url()?>src/font-awesome/css/all.min.css" rel="stylesheet"/>

    <script type="text/javascript" src="<?=base_url()?>src/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>src/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>src/js/notify.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>src/js/bootstrap-toggle.min.js"></script>

    <script type="text/javascript">
        var loading_set = '<div style="text-align:center;width:100%;height:100%; position:relative;padding-top:25%;"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
        var loading_set_np = '<div style="text-align:center;width:100%;height:100%; position:relative;"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
        
        var gchart = null;
        var gmap = null;
        var currentPathname = location.pathname;
        
        function set_page(url)
        {
            $("#page-content").html(loading_set);
            $("#page-content").load(url+"?pure&title");

            if (gchart != null){
                for (var i = 0; i < gchart.length; i++){
                    try{
                        gchart[i].destroy();
                    }catch(err){}
                }
                gchart = null;
            }
            
            if (gmap != null){
                for (var i = 0; i < gmap.length; i++){
                    try{
                        gmap[i].remove();
                    }catch(err){}
                }
                gmap = null;
                $(".jvectormap-tip").remove();
            }
            
            currentPathname = location.pathname;
        }
        
        $(document).ready(function(){
            $(window).on("popstate", function(e) {
                if (location.pathname == currentPathname)
                    return;

                currentPathname = location.pathname;

                set_page(location.href.split('#')[0]);
                $("#nav").find("a").removeClass("active");
                $("#nav a[href='"+location.href.split('#')[0]+"']").addClass("active");
            });
        });

        function copyToClipboard(text) {
            if (window.clipboardData && window.clipboardData.setData) {
                // IE specific code path to prevent textarea being shown while dialog is visible.
                return clipboardData.setData("Text", text);

            } else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
                var textarea = document.createElement("textarea");
                textarea.textContent = text;
                textarea.style.position = "fixed";  // Prevent scrolling to bottom of page in MS Edge.
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    return document.execCommand("copy");  // Security exception may be thrown by some browsers.
                } catch (ex) {
                    console.warn("Copy to clipboard failed.", ex);
                    return false;
                } finally {
                    document.body.removeChild(textarea);
                }
            }
        }
    </script>
    
    
</head>


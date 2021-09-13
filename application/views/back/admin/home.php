<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Dashboard</h1>      
</div>

<div class="row ap-hp-cards marbot20">

    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <span class="card-title"><?=$clicks_all?></span> <span>Clicks</span>
                <p class="card-text">+<?=$clicks_today?> Today</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <span class="card-title"><?=$created_urls_all?></span> <span>URLs</span>
                <p class="card-text">+<?=$created_urls_today?> Today</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <span class="card-title"><?=$registers_all?></span> <span>Users</span>
                <p class="card-text">+<?=$registers_today?> Today</p>
            </div>
        </div>
    </div>

</div>

<div class="row marbot20">
    <!--chart-->
    <div class="col-md-12">

        <div class="card border-light ">
            <div class="card-header">Summary</div>
            <div class="card-body" style="height:400px">
                <canvas id="home-page-chart"></canvas>
                <div class="no_data" style="padding-top:173px">NO DATA AVAILABLE</div>
            </div>
        </div>

    </div>

</div>

<div class="row">
    <div class="col-lg-12 marbot20">
        <div class="card border-light ">
            <div class="card-header" >
                Location Data
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 url-view-table-col" id="location_data_col">
                        <table class="table table-striped table-borderless">
                            <thead>
                            <tr>
                                <th>Country</th>
                                <th>Clicks</th>
                            </tr>
                            </thead>
                            <tbody id="location_data_table_body">
                            </tbody>
                        </table>
                        <div class="no_data" style="padding-top:123px">NO DATA AVAILABLE</div>
                    </div>
                    <div class="col-lg-6" id="location_data_map_col">

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">

    var homepagechart;
    var homepagemap;

    $(document).ready(function(){

        gmap = [];
        gmap.push(homepagemap);
        
        gchart = [];
        gchart.push(homepagechart);

        $.ajax({
            url: '<?=base_url()?>admin/get_chart_data/all?hp',
            contentType: false,
            processData: false,
            success: function( data){

              loadchart(data);
              set_location_data(data);

            },
            error: function( e ){
                console.log( e );
            }
        });

    });

    function loadchart(data) {
        try {
            homepagechart.destroy();
        } catch (err) {
        }

        data = JSON.parse(data);

        var click_labels = [];
        var click_data = [];
        var register_labels = [];
        var register_data = [];
        var url_labels = [];
        var url_data = [];

        if (data.click_chart !== "no_data") {
            for (var i = 0; i < data.click_chart.length; i++) {
                click_labels.push(data.click_chart[i][1]);
                click_data.push(data.click_chart[i][0]);
            }

            for (var i = 0; i < data.registers_chart.length; i++) {
                register_labels.push(data.registers_chart[i][1]);
                register_data.push(data.registers_chart[i][0]);
            }

            for (var i = 0; i < data.created_urls_chart.length; i++) {
                url_labels.push(data.created_urls_chart[i][1]);
                url_data.push(data.created_urls_chart[i][0]);
            }

            $("#home-page-chart").show();
            $("#home-page-chart").parent().find(".no_data").hide();

            homepagechart = new Chart(document.getElementById('home-page-chart'), {
                "type": "line",
                "data": {
                    "labels": click_labels,
                    "datasets": [{
                        "data": click_data,
                        "fill": false,
                        "borderColor": "#007bff",
                        "backgroundColor": "#82beff",
                        "label": "Clicks"
                    }, {
                        "data": url_data,
                        "fill": false,
                        "borderColor": "#4EA512",
                        "backgroundColor": "#5ADA12",
                        "label": "URLs"
                    }, {
                        "data": register_data,
                        "fill": false,
                        "borderColor": "#FF241C",
                        "backgroundColor": "#FF5951",
                        "label": "Users"
                    }]
                },
                "options": {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                stepSize: 1
                            }
                        }],
                    }
                }
            });
        } else {
            $("#home-page-chart").hide();
            $("#home-page-chart").parent().find(".no_data").show();
        }
    }

    function set_location_data(datas)
    {
        try{
            homepagemap.remove();
        }catch(err){}

        $("#location_data_map_col").html('<div id="location-data-map"></div>');

        $("#location_data_table_body").html("");
        datas = JSON.parse(datas);

        if (datas.location != "no_data")
        {
            $("#location_data_col").find(".no_data").hide();
            $("#location_data_col").find("table").show();

            var locs = {};

            for (var i = 0; i < datas.location.length; i++)
            {
                $("#location_data_table_body").append("<tr><td>"+datas.location[i][2]+"</td><td>"+datas.location[i][0]+"</td></tr>");
                locs[datas.location[i][1]] = datas.location[i][0];
            }

            homepagemap = $('#location-data-map').vectorMap({
                map: 'world_mill',
                zoomStep: 1.5,
                zoomOnScroll: false,
                series: {
                    markers: [{
                        attribute: 'fill',
                        scale: ['#FEE5D9', '#A50F15'],
                        values: locs,
                    },{
                        attribute: 'r',
                        scale: [1, 20],
                        values: locs,
                    }],
                    regions: [{
                        scale: ['#DEEBF7', '#08519C'],
                        attribute: 'fill',
                        values: locs
                    }]
                }
            });

        }
        else
        {
            homepagemap = $('#location-data-map').vectorMap({map: 'world_mill',zoomStep: 1.5,zoomOnScroll: false,});
            $("#location_data_col").find("table").hide();
            $("#location_data_col").find(".no_data").show();
        }

    }

</script>
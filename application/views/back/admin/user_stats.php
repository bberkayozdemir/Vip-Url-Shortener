<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom" style="display:block !important">
    <div class="row">
        <div class="col-lg-9 marauto">
            <h1 class="h2">User <?=$user_data->name?>s Url Statistics</h1>
        </div>
        <div class="col-lg-3">
            <select id="timeline" class="form-control">
                <option selected="" value="all">All Time</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-lg-9 marbot20">

        <div class="card border-light ">
            <div class="card-header">Click Chart</div>
            <div class="card-body" style="height:200px">
                <canvas id="url-view-chart"></canvas>
                <div class="no_data" style="padding-top:60px">NO DATA AVAILABLE</div>
            </div>
        </div>

    </div>
    
    <div class="col-lg-3 marbot20">

        <div class="card border-light ">
            <div class="card-header">
                Total Clicks
            </div>
            <div class="card-body">
                <div class="total_clicks">
                    ...
                </div>
                
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

<div class="row">
    <div class="col-lg-4 marbot20">
        
        <div class="card border-light ">
            <div class="card-header">
                Operating Systems
            </div>
            <div class="card-body" style="height:300px">
                <canvas id="operating-systems-chart"></canvas>
                <div class="no_data" style="padding-top:123px">NO DATA AVAILABLE</div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 marbot20">
        
        <div class="card border-light ">
            <div class="card-header">
                Browsers
            </div>
            <div class="card-body" style="height:300px">
                <canvas id="browsers-chart"></canvas>
                <div class="no_data" style="padding-top:123px">NO DATA AVAILABLE</div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 marbot20">
        
        <div class="card border-light ">
            <div class="card-header">
                Devices
            </div>
            <div class="card-body" style="height:300px">
                <canvas id="devices-chart"></canvas>
                <div class="no_data" style="padding-top:123px">NO DATA AVAILABLE</div>
            </div>
        </div>
    </div>
    
</div>

<script type="text/javascript">

    var user_id = "<?=$user_data->id?>";

    var click_chart;
    var devices_chart;
    var os_chart
    var browsers_chart;
    var location_data;

    $(document).ready(function(){
        gchart = [];
        gmap = [];
        gmap.push(location_data);
        gchart.push(click_chart);
        gchart.push(os_chart);
        gchart.push(browsers_chart);
        gchart.push(devices_chart);


        $("#timeline").change(function(){
            loadtime($(this).val());
        });

        loadtime("all");
    });

    function loadtime(time)
    {
        $.ajax({
            url: '<?=base_url()?>admin/get_chart_data/' + time + "/" + user_id + "/user",
            contentType: false,
            processData: false,
            success: function( data){

                if (data != "no_data") {
                    set_click_chart(data);
                    set_total_clicks(data);
                    set_pie(data, "os", os_chart, $("#operating-systems-chart"));
                    set_pie(data, "browser", browsers_chart, $("#browsers-chart"));
                    set_pie(data, "device", devices_chart, $("#devices-chart"));
                    set_location_data(data);
                }

            },
            error: function( e ){
                console.log( e );
            }
        });
    }

    function set_click_chart(datas)
    {
        try{
            click_chart.destroy();
        }catch(err){}

        datas = JSON.parse(datas);

        var labels = [];
        var cdata = [];

        if (datas.click_chart !== "no_data")
        {
            for (var i = 0; i < datas.click_chart.length; i++)
            {
                labels.push(datas.click_chart[i][1]);
                cdata.push(datas.click_chart[i][0]);
            }

            $("#url-view-chart").show();
            $("#url-view-chart").parent().find(".no_data").hide();

            click_chart = new Chart(document.getElementById('url-view-chart'), {
                "type": "line",
                "data": {
                    "labels": labels,
                    "datasets": [{
                        "data": cdata,
                        "fill": true,
                        "borderColor": "#007bff",
                        "backgroundColor": "#82beff",
                        "lineTension": 0,
                    }]
                },
                scaleSteps: 1,
                "options": {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                           label: function(tooltipItem) {
                                  return tooltipItem.yLabel;
                           }
                        }
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                            },
                            ticks: {
                                stepSize: 1
                            } 
                        }]
                    }
                }
            });
        }else{
            $("#url-view-chart").hide();
            $("#url-view-chart").parent().find(".no_data").show();
        }

    }

    function set_total_clicks(datas)
    {
        datas = JSON.parse(datas);

        $(".total_clicks").html(datas.clicks);

    }

    function set_pie(datas, type, pievar, pieselector)
    {
        try{
            pievar.destroy();
        }catch(err){}

        datas = JSON.parse(datas);

        var labels = [];
        var cdata = [];

        var dataarray;
        if (type == "os")
            dataarray = datas.os;
        else if (type == "browser")
            dataarray = datas.browser;
        else if (type == "device")
            dataarray = datas.device;

        if (dataarray !== "no_data")
        {
            for (var i = 0; i < dataarray.length; i++)
            {
                labels.push(dataarray[i][1]);
                cdata.push(dataarray[i][0]);
            }

            pieselector.show();
            pieselector.parent().find(".no_data").hide();

            pievar = new Chart(pieselector, {
                "type": "pie",
                "data": {
                    "labels": labels,
                    "datasets": [{
                        "data": cdata,
                        "fill": true,
                        backgroundColor: [
                        "rgba(66, 165, 245, 0.5)",
                        "rgba(255, 27, 27, 0.5)",
                        "rgba(253, 240, 0, 0.5)",
                        "rgba(255, 167, 0, 0.5)",
                        "rgba(39, 255, 237, 0.5)",
                        "rgba(244, 39, 255, 0.5)",
                        "rgba(70, 212, 0, 0.5)",
                        "rgba(255, 23, 182, 0.5)"
                        ],
                        "lineTension": 0,
                    }]
                },
                "options": {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            if (type == "os")
                os_chart = pievar;
            else if (type == "browser")
                browsers_chart = pievar;
            else if (type == "device")
                devices_chart = pievar;
        }else{
            pieselector.hide();
            pieselector.parent().find(".no_data").show();
        }

    }

    function set_location_data(datas)
    {
        try{
            location_data.remove();
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

            location_data = $('#location-data-map').vectorMap({
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
            location_data = $('#location-data-map').vectorMap({map: 'world_mill',zoomStep: 1.5,zoomOnScroll: false,});
            $("#location_data_col").find("table").hide();
            $("#location_data_col").find(".no_data").show();
        }

    }

</script>
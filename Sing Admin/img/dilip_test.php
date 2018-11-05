<script type="text/javascript" src="http://www.amcharts.com/lib/3/amcharts.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/pie.js"></script>
<script type="text/javascript" src="http://www.amcharts.com/lib/3/themes/none.js"></script>
<script>
var chart;
var chart2;
var legend;
var selected;

var types = [{
    type: "Fossil Energy",
    percent: 70, 
    color: "#ff9e01",
    subs: [
        { type: "Oil", percent: 15 },
        { type: "Coal", percent: 35 },
        { type: "Nuclear", percent: 20 }
    ]},
{
    type: "Green Energy",
    percent: 30,
    color: "#b0de09",
    subs: [
        { type: "Hydro", percent: 15 },
        { type: "Wind", percent: 10 },
        { type: "Other", percent: 5 }
    ]}
];

function generateChartData () {
    var chartData = [];
    for (var i = 0; i < types.length; i++) {
        if (i == selected) {
            for (var x = 0; x < types[i].subs.length; x++) {
                chartData.push({
                    type: types[i].subs[x].type,
                    percent: types[i].subs[x].percent,
                    color: types[i].color,
                    pulled: true
                });
            }
        }
        else {
            chartData.push({
                type: types[i].type,
                percent: types[i].percent,
                color: types[i].color,
                id: i
            });
        }
    }
    return chartData;
}

AmCharts.ready(function() {
    // PIE CHART
    chart = new AmCharts.AmPieChart();
    chart.dataProvider = generateChartData();
    chart.titleField = "type";
    chart.valueField = "percent";
    chart.outlineColor = "#FFFFFF";
    chart.outlineAlpha = 0.8;
    chart.outlineThickness = 2;
    chart.colorField = "color";
    chart.pulledField = "pulled";
    
    // ADD TITLE
    chart.addTitle("Click a slice to see the details");
    
    // AN EVENT TO HANDLE SLICE CLICKS
    chart.addListener("clickSlice", function (event) {
        if (event.dataItem.dataContext.id != undefined) {
            selected = event.dataItem.dataContext.id;
        }
        else {
            selected = undefined;
        }
        chart.dataProvider = generateChartData();
        chart.validateData();
    });

    // WRITE
    chart.write("chartdiv");
    
    chart2 = new AmCharts.AmPieChart();
    chart2.dataProvider = generateChartData();
    chart2.titleField = "type";
    chart2.valueField = "percent";
    chart2.outlineColor = "#FFFFFF";
    chart2.outlineAlpha = 0.8;
    chart2.outlineThickness = 2;
    chart2.colorField = "color";
    chart2.pulledField = "pulled";
    
    // ADD TITLE
    chart2.addTitle("Click a slice to see the details");
    
    // AN EVENT TO HANDLE SLICE CLICKS
    chart2.addListener("clickSlice", function (event) {
        if (event.dataItem.dataContext.id != undefined) {
            selected = event.dataItem.dataContext.id;
        }
        else {
            selected = undefined;
        }
        chart2.dataProvider = generateChartData();
        chart2.validateData();
    });

    // WRITE
    chart2.write("chart2div");
    
    
});
</script>
<style>
#chartdiv {
	width		: 100%;
	height		: 500px;
	font-size	: 11px;
}	
#chart2div {
	width		: 100%;
	height		: 500px;
	font-size	: 11px;
}	
</style>
<div id="chartdiv"></div>
<hr /><hr />
<div id="chart2div"></div>								
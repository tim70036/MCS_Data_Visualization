<!-- Layout for 4 chart -->
<div class="row">
  <div class="col-md-4" id="area1"></div>
  <div class="col-md-4" id="area2"></div>
</div>

<div class="row">
  <div class="col-md-4" id="area3"></div>
  <div class="col-md-4" id="area4"></div>
</div>

<div class="row">
  <input type="radio" name="radData" id="rad1" onclick="change();">
</div>


<style>
    .arc text {
      font: 10px sans-serif;
      text-anchor: middle;
    }

    .arc path {
      stroke: #fff;
    }

    /* Setting for text on the chart */
    .toolTip {
        position: absolute;
        display: none;
        width: auto;
        height: auto;
        background: none repeat scroll 0 0 white;
        border: 0 none;
        border-radius: 8px 8px 8px 8px;
        box-shadow: -3px 3px 15px #888888;
        color: black;
        font: 12px sans-serif;
        padding: 5px;
        text-align: center;
    }
</style>


<script>
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "https://api.mediatek.com/mcs/v2/devices/D50Vc0GM/datachannels/Test_only/datapoints?limit=1000", true);
    xhr.setRequestHeader("deviceKey", "jur0mgrSH4gJ8KJr")
    xhr.setRequestHeader("Content-Type", "application/json")

    /* Set call back function */
    xhr.onreadystatechange = function(){
        /* If the request is done and the response is successful */
        if(xhr.readyState == 4 && xhr.status == 200) 
        {
            var data = JSON.parse(xhr.response)
            console.log(data.dataChannels[0].dataPoints[0].values.value);
        }
    }

    xhr.send();
</script>

<script>

/* The text on the chart */
//var div = d3.select("body").append("div").attr("class", "toolTip");
var dataset = [
	{ name: 'Firearms', total: 8124, percent: 67.9 },
	{ name: 'Knives or cutting instruments', total: 1567, percent: 13.1 },
	{ name: 'Other weapons', total: 1610, percent: 13.5 },
	{ name: 'Hands, fists, feet, etc.', total: 660, percent: 5.5 }
];

var dataset2 = [
  { name: 'Firearms', total: 1000, percent: 50 },
  { name: 'shit', total: 2000, percent: 50 }
];

var dataset3 = [
  { name: 'Firearms', total: 1000, percent: 50 },
  { name: 'shit', total: 1000, percent: 50 }
];

var dataset4 = [
  { name: 'Firearms', total: 2000, percent: 50 },
  { name: 'shit', total: 1000, percent: 50 }
];

/* Set up */
var width = 480,
    height = 250,
    radius = Math.min(width, height) / 2;
var color = d3.scale.ordinal()
    .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56"]);

var arc = d3.svg.arc()
                .outerRadius(radius - 10)
                .innerRadius(radius - 70);

var pie = d3.layout.pie()
                    .sort(null)
                    .startAngle(1.1*Math.PI)
                    .endAngle(3.1*Math.PI)
                    .value(function(d) { return d.total; });

/* Add element */
var chart1 = d3.select("#area1").append("svg")
                .attr("width", width)
                .attr("height", height)
                .append("g")
                .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

var g = chart1.selectAll(".arc")
              .data(pie(dataset))
              .enter().append("g")
              .attr("class", "arc"); /* setting all of g in chart1 to class arc */
/* Color of chart for different data */
g.append("path")
 .style("fill", function(d) { return color(d.data.name); })
 .transition().delay(function(d,i) {return i * 500; })
 .duration(1500)
 .attrTween('d', function(d) 
   {
     var i = d3.interpolate(d.startAngle+0.1, d.endAngle);
     return function(t) 
     {
 	      d.endAngle = i(t); 
 		    return arc(d)
  	 }
	})
 .each(function(d) { this._current = d; console.log(this._current); }); // store the initial angles 


function change() {
    g.data(pie(dataset2));
    g.transition().duration(750).attrTween("d", arcTween); // redraw the arcs

}

// Store the displayed angles in _current.
// Then, interpolate from _current to the new angles.
// During the transition, _current is updated in-place by d3.interpolate.

function arcTween(a) {
    var i = d3.interpolate(this._current, a);
    this._current = i(0);
    return function(t) {
        return arc(i(t));
    };
}


/* Text on chart */
g.append("text")
    .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
    .attr("dy", ".35em")
  .transition()
  .delay(1500)
    .text(function(d) { return d.data.name; });



/* Add element */
var chart2 = d3.select("#area2").append("svg")
                .attr("width", width)
                .attr("height", height)
                .append("g")
                .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

var g2 = chart2.selectAll(".arc")
              .data(pie(dataset2))
              .enter().append("g")
              .attr("class", "arc"); /* setting all of g in chart1 to class arc */
/* Color of chart for different data */
g2.append("path")
 .style("fill", function(d) { return color(d.data.name); })
 .transition().delay(function(d,i) {return i * 500; })
 .duration(1500)
 .attrTween('d', function(d) 
   {
     var i = d3.interpolate(d.startAngle+0.1, d.endAngle);
     return function(t) 
     {
        d.endAngle = i(t); 
        return arc(d)
     }
  }); 



/* Add element */
var chart3 = d3.select("#area3").append("svg")
                .attr("width", width)
                .attr("height", height)
                .append("g")
                .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

var g3 = chart3.selectAll(".arc")
              .data(pie(dataset3))
              .enter().append("g")
              .attr("class", "arc"); /* setting all of g in chart1 to class arc */
/* Color of chart for different data */
g3.append("path")
 .style("fill", function(d) { return color(d.data.name); })
 .transition().delay(function(d,i) {return i * 500; })
 .duration(1500)
 .attrTween('d', function(d) 
   {
     var i = d3.interpolate(d.startAngle+0.1, d.endAngle);
     return function(t) 
     {
        d.endAngle = i(t); 
        return arc(d)
     }
  }); 


/* Add element */
var chart4 = d3.select("#area4").append("svg")
                .attr("width", width)
                .attr("height", height)
                .append("g")
                .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

var g4 = chart4.selectAll(".arc")
              .data(pie(dataset4))
              .enter().append("g")
              .attr("class", "arc"); /* setting all of g in chart1 to class arc */
/* Color of chart for different data */
g4.append("path")
 .style("fill", function(d) { return color(d.data.name); })
 .transition().delay(function(d,i) {return i * 500; })
 .duration(1500)
 .attrTween('d', function(d) 
   {
     var i = d3.interpolate(d.startAngle+0.1, d.endAngle);
     return function(t) 
     {
        d.endAngle = i(t); 
        return arc(d)
     }
  }); 



	// d3.selectAll("path").on("mousemove", function(d) {
	//     div.style("left", d3.event.pageX+10+"px");
	// 	  div.style("top", d3.event.pageY-25+"px");
	// 	  div.style("display", "inline-block");
    //div.html((d.data.name)+"<br>"+(d.data.total) + "<br>"+(d.data.percent) + "%");
// });
	  
// d3.selectAll("path").on("mouseout", function(d){
//     div.style("display", "none");
// });
	  
	  
//d3.select("body").transition().style("background-color", "#d3d3d3");
function type(d) {
  d.total = +d.total;
  return d;
}

</script>

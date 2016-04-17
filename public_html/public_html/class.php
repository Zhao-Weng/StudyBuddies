<?php
session_start();
include_once 'scripts/connectDB.php';

if(!isset($_SESSION['user'])){
	header("Location: index.php");
}
$session = $_SESSION['user'];
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<title>StudyBuddies</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<link href='http://fonts.googleapis.com/css?family=Arimo:400,700' rel='stylesheet' type='text/css'>
	<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

	<script src="js/skel.min.js"></script>
	<script src="js/skel-panels.min.js"></script>
	<script src="js/init.js"></script>
	<noscript>
		<link rel="stylesheet" href="css/skel-noscript.css" />
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/style-desktop.css" />
	</noscript>
	<!--<script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>-->
	<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	<!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->

<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,600,200italic,600italic&subset=latin,vietnamese' rel='stylesheet' type='text/css'>
</head>
<body>
	<!-- Header -->
	<div id="header">
		<div class="container"> 
			<!-- Logo -->
			<div id="logo">
				<h1><a href="#">StudyBuddies</a></h1>
				<span>Design by TEAM 38</span>
			</div>
			<!-- Nav -->
			<nav id="nav">
				<ul>
					<li><a href="home.php">Homepage</a></li>
					<li><a href="change.php">Change</a></li>
					<li><a href="chat.php">Chat</a></li>
					<li><a href="logout.php?logout">Sign Out</a></li>
				</ul>
			</nav>
		</div>
	</div>
	<!-- Main -->
	<div id="main">
		<div class="container">
			<a href="#" onclick="loaddata()">Check For Popular Courses!</a>
			<div id="classes"></div>
			<a href="#" onclick="drawuser()">Check For Popular Users!</a>
			<div id="json" class="bubbleChart"/> </div>
		</div>
	</div>
<style>
.arc text {
  font: 10px sans-serif;
  text-anchor: middle;
}

.arc path {
  stroke: #fff;
}
</style>
<script src="//d3js.org/d3.v3.min.js"></script>
<script>
$("#json").hide();
function loaddata(){
	$.ajax({url:"scripts/courses.php",success:function(){
		 var http = new XMLHttpRequest();
    	http.open('HEAD', "scripts/data.csv", false);
    	http.send();
    	if(http.status!=404){
			draw();
		}
	}});
}
var jsondata;
function drawuser(){
	$.ajax({url:"scripts/users.php",success:function(){
	  var oReq = new XMLHttpRequest();
	  oReq.onload = function () {
	      jsondata = JSON.parse(this.responseText);
	      drawjson();
	  };
	  oReq.open("get", "scripts/data.json", true);
	  oReq.send();
	}});
}

function drawjson(){
  $("#classes").empty();
  $("#json").empty();
  $("#json").show();
  var bubbleChart = new d3.svg.BubbleChart({
    supportResponsive: true,
    size: 600,
    innerRadius: 600 / 3.5,
    radiusMin: 50,

    data: {
      items: jsondata,
      eval: function (item) {return item.count;},
      classed: function (item) {return item.text.split(" ").join("");}
    },
    plugins: [
      {
        name: "central-click",
        options: {
          text: "",
          style: {
            "font-size": "12px",
            "font-style": "italic",
            "font-family": "Source Sans Pro, sans-serif",
            //"font-weight": "700",
            "text-anchor": "middle",
            "fill": "white"
          },
          attr: {dy: "65px"},
          centralClick: function() {
          //alert("Here is more details!!");
          }
        }
      },
      {
        name: "lines",
        options: {
          format: [
            {// Line #0
              textField: "count",
              classed: {count: true},
              style: {
                "font-size": "28px",
                "font-family": "Source Sans Pro, sans-serif",
                "text-anchor": "middle",
                fill: "white"
              },
              attr: {
                dy: "0px",
                x: function (d) {return d.cx;},
                y: function (d) {return d.cy;}
              }
            },
            {// Line #1
              textField: "text",
              classed: {text: true},
              style: {
                "font-size": "14px",
                "font-family": "Source Sans Pro, sans-serif",
                "text-anchor": "middle",
                fill: "white"
              },
              attr: {
                dy: "20px",
                x: function (d) {return d.cx;},
                y: function (d) {return d.cy;}
              }
            }
          ],
          centralFormat: [
            {// Line #0
              style: {"font-size": "50px"},
              attr: {}
            },
            {// Line #1
              style: {"font-size": "30px"},
              attr: {dy: "40px"}
            }
          ]
        }
      }]
  });
}



function draw(){
	$("#json").empty();
	$("#json").hide();
	$("#classes").empty();
	var width = 960,
	    height = 500,
	    radius = Math.min(width, height) / 2;

	var color = d3.scale.ordinal()
	    .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

	var arc = d3.svg.arc()
	    .outerRadius(radius - 10)
	    .innerRadius(radius - 70);

	var pie = d3.layout.pie()
	    .sort(null)
	    .value(function(d) { return d.num; });

	var svg = d3.select("#classes").append("svg")
	    .attr("width", width)
	    .attr("height", height)
	  .append("g")
	    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

	d3.csv("scripts/data.csv", type, function(error, data) {
	  if (error){ throw error;}
	  var g = svg.selectAll(".arc")
	      .data(pie(data))
	    .enter().append("g")
	      .attr("class", "arc");

	  g.append("path")
	      .attr("d", arc)
	      .style("fill", function(d) { return color(d.data.coursecode); });

	  g.append("text")
	      .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
	      .attr("dy", ".35em")
	      .text(function(d) { return d.data.coursecode; });
	});
}
function type(d) {
  d.num = +d.num;
  return d;
}
</script>

  <script src="http://phuonghuynh.github.io/js/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/d3/d3.min.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/d3-transform/src/d3-transform.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/cafej/src/extarray.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/cafej/src/misc.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/cafej/src/micro-observer.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/microplugin/src/microplugin.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/bubble-chart/src/bubble-chart.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/bubble-chart/src/plugins/central-click/central-click.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/bubble-chart/src/plugins/lines/lines.js"></script>

<style>
    .bubbleChart {
      min-width: 100px;
      max-width: 700px;
      height: 700px;
      margin: 0 auto;
    }
   
  </style>
</body>
</html>
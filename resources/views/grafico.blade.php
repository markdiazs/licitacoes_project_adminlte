@extends('layouts.app',['currtent' => 'grafico anual'])
@section('body')
<style>

body {
  font-family: 'Open Sans', sans-serif;
}

svg {
  text-align: center;
}

svg{
  width: 1000px;
  height: 600px;
  margin: auto;
  background-color: #2F4A6D;
}

svg {
  width: 100%;
  height: 100%;
}

.bar {
  fill: #80cbc4;
}

text {
  font-size: 12px;
  fill: #fff;
}

path {
  stroke: gray;
}

line {
  stroke: gray;
}

line#limit {
  stroke: #FED966;
  stroke-width: 3;
  stroke-dasharray: 3 6;
}

.grid path {
  stroke-width: 0;
}

.grid .tick line {
  stroke: #9FAAAE;
  stroke-opacity: 0.3;
}

text.divergence {
  font-size: 14px;
  fill: #2F4A6D;
}

text.value {
  font-size: 14px;
}

text.title {
  font-size: 22px;
  font-weight: 600;
}

text.label {
  font-size: 14px;
  font-weight: 400;
}

text.source {
  font-size: 10px;
}
</style>

<div id="graphic"></div>

<svg style="width: 900px;height: 570px;" ></svg>

<script>

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
            crossDomain: true,
            async: true,
            cache: false,
            timeout: 15000,
            type:"GET",
            url: 'http://10.8.15.197:3030/graficoanualapi',
            dataType: 'json',
            success: function(retorno) {
                if(retorno) {
                    //sort bars based on value
                    data = retorno;
                    console.log(data);

                const margin = 60;
                const width = 1000 - 2 * margin;
                const height = 600 - 2 * margin;

                const svg = d3.select('svg');

                const chart = svg.append('g')
                .attr('transform', `translate(${margin}, ${margin})`);

                const yScale = d3.scaleLinear()
                .range([height, 0])
                .domain([0, d3.max(data, function(d){return d[1];})]);

                chart.append('g')
                .call(d3.axisLeft(yScale));

                const xScale = d3.scaleBand()
                .range([0, width])
                .domain(data.map((d) => d[0]))
                .padding(0.2)

                chart.append('g')
                .attr('transform', `translate(0, ${height})`)
                .call(d3.axisBottom(xScale));

                const barGroups = chart.selectAll()
                .data(data)
                .enter()
                .append('g')

                barGroups
                .append('rect')
                .attr('class','bar')
                .attr('x', (d) => xScale(d[0]))
                .attr('y', (d) => yScale(d[1]))
                .attr('height', (d) => height - yScale(d[1]))
                .attr('width', xScale.bandwidth())
                .on('mouseenter', function (actual, i) {
                        d3.selectAll('.value')
                        .attr('opacity', 0)

                        d3.select(this)
                        .transition()
                        .duration(300)
                        .attr('opacity', 0.6)
                        .attr('x', (d) => xScale(d[0]) - 5)
                        .attr('width', xScale.bandwidth() + 10)

                        const y = yScale(actual[1])

                        line = chart.append('line')
                        .attr('id', 'limit')
                        .attr('x1', 0)
                        .attr('y1', y)
                        .attr('x2', width)
                        .attr('y2', y)

                        barGroups.append('text')
                        .attr('class', 'divergence')
                        .attr('x', (d) => xScale(d[0]) + xScale.bandwidth() / 2)
                        .attr('y', (d) => yScale(d[1]) + 30)
                        .attr('fill', 'white')
                        .attr('text-anchor', 'middle')
                        .text((d, idx) => {
                            const divergence = (d[1] - actual[1]).toFixed(1)

                            let text = ''
                            if (divergence > 0) text += '+'
                            text += `${divergence}%`

                            return idx !== i ? text : '';
                        })
                    })
                    .on('mouseleave', function () {
                        d3.selectAll('.value')
                        .attr('opacity', 1)

                        d3.select(this)
                        .transition()
                        .duration(300)
                        .attr('opacity', 1)
                        .attr('x', (d) => xScale(d[0]))
                        .attr('width', xScale.bandwidth())

                        chart.selectAll('#limit').remove()
                        chart.selectAll('.divergence').remove()
                    })


                // grid
                    chart.append('g')
                        .attr('class', 'grid')
                        .attr('transform', `translate(0, ${height})`)
                        .call(d3.axisBottom()
                            .scale(xScale)
                            .tickSize(-height, 0, 0)
                            .tickFormat(''))

                    chart.append('g')
                        .attr('class', 'grid')
                        .call(d3.axisLeft()
                            .scale(yScale)
                            .tickSize(-width, 0, 0)
                            .tickFormat(''))
                // fimgrid
                svg.append('text')
                .attr('x', -(height / 2) - margin)
                .attr('y', margin / 2.4)
                .attr('transform', 'rotate(-90)')
                .attr('text-anchor', 'middle')
                .text('Licitações por ano')

                svg.append('text')
                .attr('x', width / 2 + margin)
                .attr('y', 40)
                .attr('text-anchor', 'middle')
                .text('Licitações por TRT8 PA/AP');

              //     //set up svg using margin conventions - we'll need plenty of room on the left for labels
                //     var margin = {
                //         top: 15,
                //         right: 25,
                //         bottom: 15,
                //         left: 60
                //     };

                //     var width = 960 - margin.left - margin.right,
                //         height = 500 - margin.top - margin.bottom;

                //     var svg = d3.select("#graphic").append("svg")
                //         .attr("width", width + margin.left + margin.right)
                //         .attr("height", height + margin.top + margin.bottom)
                //         .append("g")
                //         .attr("transform", "translate(" + margin.left + "," + margin.top + ")");




                //     var x = d3.scale.linear()
                //         .range([0, width])
                //         .domain([0, d3.max(data, function (d) {
                //             return d[1];
                //         })]);

                //     var y = d3.scale.ordinal()
                //                     .rangeRoundBands([height, 0], .1)
                //     .domain(data.map(function (d) {
                //         return d[0];
                //     }));

                // //make y axis to show bar names
                // var yAxis = d3.svg.axis()
                //     .scale(y)
                //     //no tick marks
                //     .tickSize(0)
                //     .orient("left");

                // var gy = svg.append("g")
                //     .attr("class", "y axis")
                //     .call(yAxis)

                // var bars = svg.selectAll(".bar")
                //     .data(data)
                //     .enter()
                //     .append("g")

                // //append rects
                // bars.append("rect")
                //     .attr("class", "bar")
                //     .attr("y", function (d) {
                //         return y(d[0]);
                //     })
                //     .attr("height", y.rangeBand())
                //     .attr("x", 0)
                //     .attr("width", function (d) {
                //         return x(d[1]);
                //     });

                // //add a value label to the right of each bar
                // bars.append("text")
                //     .attr("class", "label")
                //     //y position of the label is halfway down the bar
                //     .attr("y", function (d) {
                //         return y(d[0]) + y.rangeBand() / 2 + 4;
                //     })
                //     //x position is 3 pixels to the right of the bar
                //     .attr("x", function (d) {
                //         return x(d[1]) + 3;
                //     })
                //     .text(function (d) {
                //         return d[1];
                //     });
                // }


        }

    }
 });





</script>

@endsection

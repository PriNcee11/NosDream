/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawTrendlines);

function drawTrendlines() {
    var data = new google.visualization.DataTable();
    data.addColumn('number', 'Hora');
    data.addColumn('number', 'Precio');

    data.addRows([
        [1, 1],
        [2, 2],
        [3, 3],
        [4, 4],
        [5, 5],
        [6, 6],
        [7, 2],
        [8, 8],
        [9, 6],
        [10, 1],
    ]);

    var options = {
        trendlines: {
            0: {type: 'linear', lineWidth: 5, opacity: .3},
            1: {type: 'exponential', lineWidth: 10, opacity: .3}
        },
        legend: {position: 'none'},
        hAxis: {
            title: '',
            viewWindow: {
                min: [7, 30, 0],
                max: [17, 30, 0]
            }
        },
        chartArea: {left: 0, top: 0, width: '100%', height: '100%'}
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}
/*
@title compare
@description Our Stock chart can support any number of stock panels. And you can even add or remove them at run time. You can use one panel to show price change and another - volume change. More panels can be added for technical indicators and other technical analysis. Each Stock Panel can have any number of graphs. Each Stock Panel is a separate serial chart and is based on AmSerialChart and so it can do anything this chart can.
*/
$(function() {
  var seriesOptions = [],
    yAxisOptions = [],
    seriesCounter = 0,
    names = ['MSFT', 'AAPL', 'GOOG'],
    colors = Highcharts.getOptions().colors;

  $.each(names, function(i, name) {

    $.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename='+ name.toLowerCase() +'-c.json&callback=?', function(data) {

      seriesOptions[i] = {
        name: name,
        data: data
      };

      // As we're loading the data asynchronously, we don't know what order it will arrive. So
      // we keep a counter and create the chart when all the data is loaded.
      seriesCounter++;

      if (seriesCounter == names.length) {
        createChart();
      }
    });
  });



  // create the chart when all data is loaded
  function createChart() {

    $('#chart').highcharts('StockChart', {

        rangeSelector: {
        inputEnabled: $('#container').width() > 480,
            selected: 4
        },

        yAxis: {
          labels: {
            formatter: function() {
              return (this.value > 0 ? '+' : '') + this.value + '%';
            }
          },
          plotLines: [{
            value: 0,
            width: 2,
            color: 'silver'
          }]
        },
        
        plotOptions: {
          series: {
            compare: 'percent'
          }
        },
        
        tooltip: {
          pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.change}%)<br/>',
          valueDecimals: 2
        },
        
        series: seriesOptions
    });
  }

});
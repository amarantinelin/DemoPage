/*
@description  Our Stock chart can display different kind of annotations on the graph or on the axis. These annotations or stock events as we call them can mark important news or events connected to the security or bond. As you see, there is a wide variety of event types - they can look like a flag or sign or pin and have a letter inside or even contain more text. When user rolls-over the event, you can show a more detailed description or register this event and display some information outside the chart. The events are nicely stacked one on another if there is more than one for the same date.
AAPL historical OHLC data from the Google Finance API 
@title        single line chart
 */
$(function() {

  $.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename=aapl-c.json&callback=?', function(data) {
    // Create the chart
    $('#chart').highcharts('StockChart', {
      

      rangeSelector : {
        selected : 1,
        inputEnabled: $('#container').width() > 480
      },

      title : {
        text : 'AAPL Stock Price'
      },
      
      series : [{
        name : 'AAPL',
        data : data,
        tooltip: {
          valueDecimals: 2
        }
      }]
    });
  });

});

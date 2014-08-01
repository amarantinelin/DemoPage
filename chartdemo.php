<html>
<head>
	<title>Chart Demo
	</title>
   <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />

	<link href="css/normalize.css" rel="stylesheet">
	<link href="css/style1.css" rel="stylesheet">

	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
	<link rel="stylesheet" href="lib/codemirror.css">

  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
  <div class="wrapper">
	<div class="container">
	<div class="side">
		<div class="side__logo">
			Charts Demo
		</div>
		<ul class="side__chartnames">
			 <?php 
                    $dom = new DOMDocument;

                    $dir = "config/*";
          

                    foreach (glob($dir) as $file) {

                       $str_data = file_get_contents($file);  

                       $titlepattern = '/@title\s+(.+?)(?=\s*@|\s*\*\/)/s';
                       $descrpattern = '/@description\s+(.+?)(?=\s*@|\s*\*\/)/s';

                       preg_match($titlepattern, $str_data, $titlematches);
                       preg_match($descrpattern, $str_data, $descrmatches);

                       echo '<li class="side__chartname" data-js="'.$file.'"'.'data-descr="'.$descrmatches[1].'">'.$titlematches[1].'</li>';
                    }
                ?>
		</ul>
	</div>

	<div class="main">
     <div>
        <select class="chart__themes">
          <option value="default">Default Theme</option>
           <?php
                $dom = new DOMDocument;
                $dir = "themes/*";
                foreach (glob($dir) as $file) {
                    $themefile = basename($file);
                    $themename = basename($file,".js");

                    $themereplace = str_replace('-', ' ', $themename);


                    echo '<option class="chart__theme" value='.$file.'>'.strtoupper($themereplace).'</option>';
                 
                }
           ?>
        </select> <p class="write"></p>
     </div>
     <div class="main_content">
		<div class="chartbox">
      <div class="leftarrow arrow"><i class="fa fa-angle-left fa-3x"></i></div>
      <div class="chart" id="chart"></div>
      <div class="rightarrow arrow"><i class="fa fa-angle-right fa-3x"></i></div>
    </div>
    <div class="descr">
      <h1>Chart Description</h1>
      <p class="description"></p>
    </div>
		<div class="config">
			<div class="config__features">
			 	<button class="btn__feature">Select chart feature</button>
        <div class="feature__area on">
          <span class=""><input type="checkbox" class="feature plotYline">Plot lines on Y axis</span>
          <span class=""><input type="checkbox" class="feature plotYband">Plot bands on Y axis</span>
          <span class=""><input type="checkbox" class="feature reverseY">Reverse Y axis</span>
        </div>
			</div>
			
		</div>
    <div class="codeedit">
      <div class="demo-panel-white"> 
        <div class="demo-panel-navbar">
          <ul class="demo-panel-options">
            <li class="demo-panel-option" edit="example">Chart Options</li>
            <li class="demo-panel-option" edit="theme">Visual Theme</li>
          </ul>
          <button class="run">Run</button>
        </div>
    
		    <div class="editor" id="editor_example"></div>
        <div class="editor hidden" id="editor_theme"></div>
		  </div>
  </div>
	
  </div>
	</div>


</div>

<footer>
     <span class="api">API</span>
     <span class="sharing"><a>Social Sharing</a></span>
 </footer>
</div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
   <script src="http://code.highcharts.com/stock/highstock.js"></script>
    <script src="http://code.highcharts.com/stock/modules/exporting.js"></script>

    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
    <script src="lib/codemirror-compressed.js"></script>
	<script src="js/script.js" type="text/javascript"></script>
	 <script type="text/javascript">
          $(document).ready(function(){
              $('.side__chartnames li:nth-child(1)').addClass('active');
              $.getScript($('.side__chartnames li:nth-child(1)').attr('data-js'))
                .done(function(t){
                     Highcharts.text = t.replace(/\/\*[\s\S]*?\*\/\s*/,'');
                            Highcharts.editor_example.setValue(Highcharts.text);
                });
                 $(".description").text( $('.side__chartnames li:nth-child(1)').attr('data-descr'));

          });
	 		  
            $(function(){
                $('.side__chartnames').find('li').each(function(){
                    $(this).click(function(){
                      $(this).siblings('li').removeClass('active');
                        $.getScript($(this).attr('data-js'))
                          .done(function(t){
                            Highcharts.text = t.replace(/\/\*[\s\S]*?\*\/\s*/,'');
                            Highcharts.editor_example.setValue(Highcharts.text);
                          });
                        $(".description").text(this.getAttribute('data-descr'));
                    });

                });

            });

          
            $(".feature").on('change',function(){
                 if($(".plotYline").is(":checked"))
                 {
                     var chart = $('#chart').highcharts().yAxis[0];
                         var max = chart.max;
                         var min = chart.min;
                         chart.addPlotLine({
                            value: (max + min)/2,
                            color : 'red',
                            dashStyle : 'shortdash',
                            width : 2,
                            id: 'plotline-1',
                            label : {
                              text : 'Last quarter Average'
                            }
                        });
                 }
                 else{
                      var chart = $('#chart').highcharts().yAxis[0];
                      chart.removePlotLine('plotline-1');
                 }

                 if($(".plotYband").is(":checked"))
                 {
                      var chart = $('#chart').highcharts().yAxis[0];
                         var max = chart.max;
                         var min = chart.min;
                         chart.addPlotBand({
                              from: max,
                              to: min,
                              color:'rgba(68, 170, 213, 0.2)',
                              id: 'plotband-1',
                              label : {
                                text : 'Last quarter\'s value range'
                              }
                         });
                 }else{
                      var chart = $('#chart').highcharts().yAxis[0];
                      chart.removePlotBand('plotband-1');
                 }

                 
                
            });
          

              $(".reverseY").click(function(){
                   var chart = $('#chart').highcharts().yAxis[0];
                       var yAxis = chart.reversed;
                        if(yAxis == 1)
                        {
                          chart.update({reversed:0});
                        }
                        else
                        {
                           chart.update({reversed: 1});
                        }
                      });


              Highcharts.defaultOptions = $.extend(true, {}, Highcharts.getOptions());

            $('.chart__themes').change(function(){
                if($(this).val()=="default"){
                   for(i in o=Highcharts.getOptions()) delete o[i];
                      $.extend(true, o, Highcharts.defaultOptions);
                     $.getScript($('.active').attr('data-js'));
                }
                else{
                 for(i in o=Highcharts.getOptions()) delete o[i];
                      $.extend(true, o, Highcharts.defaultOptions);
                    
                $.getScript(this.value)
                   .done(function(t){
                         $.getScript($('.active').attr('data-js'));
                          Highcharts.editor_theme.setValue(t);
                          });
                  }
              });
          
            Highcharts.editor_example = CodeMirror(document.getElementById("editor_example"), {
              value: '',
              mode:  "javascript",
              lineNumbers: true,
              
              indentUnit: 4,
              });

            Highcharts.editor_theme = CodeMirror(document.getElementById("editor_theme"), {
              value: '',
              mode:  "javascript",
              lineNumbers: true,
              
              indentUnit: 4,
              });

          
            $(".run").click(function(){
                eval(Highcharts.editor_example.getValue());

            });


            $(".rightarrow").click(function(){
                  if($(".active").next('li').length > 0)
                  {
                    $(".active").next('li').click();
                  }
                  else
                  {
                    $(".rightarrow").addClass('disable');
                  }
            });


              $(".leftarrow").click(function(){
                  if($(".active").prev('li').length > 0)
                  {
                    $(".active").prev('li').click();
                  }
                  else
                  {
                    $(".leftarrow").addClass('disable');
                  }
            });

                $(".btn__feature").click(function(){
                  if($(".feature__area").hasClass("on")){
                      $(".feature__area").removeClass("on");
                    }else{
                       $(".feature__area").addClass("on");
                    }


                });

                $(".demo-panel-option").click(function(){
                  var id="editor_" + $(this).attr('edit');
                    $(this).addClass('active').siblings('li').removeClass('active');  
                     $('#'+id).removeClass('hidden').siblings('.editor').addClass('hidden');
                     Highcharts[id].refresh();
                });

                
                   
                

    </script>



</body>
</html>
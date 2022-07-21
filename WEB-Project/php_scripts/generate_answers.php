<?php

function split_inputs($row)
{
    $row = explode(";",$row)[0];
    $res = '';
    $elements = explode(",",$row);
    if(count($elements) == 1) return "";
    $res = $res . "<div class='quest'><label class='title'>" .explode('=',$elements[0])[1] . "</label>";
    
    
    if(explode('=',$elements[1])[1] == "radio" || explode('=',$elements[1])[1]  == "checkbox"){
        
        
        $number_of_options = explode('=',$elements[2])[1];
        $name = explode('=',$elements[3])[1];
        $type = explode('=',$elements[1])[1];
        
        for($i=0;$i<$number_of_options;$i++){
            $label = explode('=',$elements[4 + $i*2])[1];
            $value = explode('=',$elements[5 + $i*2])[1];
            $res = $res . "<div class='multi'>";
            $res = $res . "<input type='$type' class='$type' name='" . $name . "[]' label = '$label'  value = '$value'>";
            $res = $res . "<label class='radio_label'>$label</label> </div>";
            
        }
        $res = $res . "</div>";
    }
    
    else{
        
        $type = trim(explode('=',$elements[1])[1]);
        $res = $res . "<input class='input' required ";
           foreach($elements as $element){
               $el = explode('=',$element);
               $res = $res . "$el[0]='" . trim($el[1]) . "'";
           }
        if($type == "file"){
            $res = $res . " id='" . trim(explode('=',$elements[2])[1]) . "' ";
        }
        $res = $res . "> </div>";
       }
  return $res;
}

function get_names_array($rows)
{
  $gathered_stems_names_types = [];
  foreach ($rows as $single_row_str) {
    $gathered_row = [];
    $row = explode(',', $single_row_str);
    foreach ($row as $i => $element) {
      $key_value = explode("=", $element);
      if ($key_value[0] == 'stem') {
        array_push($gathered_row, $key_value[1]);
      }
      if ($key_value[0] == 'name') {
        array_push($gathered_row, $key_value[1]);
      }
        if ($key_value[0] == 'type') {
        array_push($gathered_row, $key_value[1]);
      }
        
    }
    array_push($gathered_stems_names_types, $gathered_row);
  }
  return $gathered_stems_names_types;
}

function generate_answer($id,$question,$answers,$type){
    
    if(strlen($question) == 0){
        return "";
    }
    
    $res = "<div class='quest'> <label class='title'>$question</label>";
    
    if(is_array($answers[0])){
        
        $counts = array();
        
        foreach($answers as $temp){
            foreach($temp as $value){
                if(array_key_exists($value,$counts)){
                    $counts[$value]++;
                }
                else{
                    $counts[$value]=1;
                }
            }
        }
        
        $res = $res . "
        <div id= 'donutchart'></div>
        <script type='text/javascript'>
         google.charts.load('current', {
  callback: function () {
    var data = google.visualization.arrayToDataTable([
        ['Answear', 'Times']";
        
        foreach($counts as $key => $value){
            $res = $res . ",['" . $key . "'," . $value . "]";
        }
        
        $res = $res . "]);

        var options = {
         
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));

        chart.draw(data, options);
  },
  packages: ['corechart', 'gauge']
});
      
      

      
    </script>
    
    ";
        
        
    }else if($type == "file"){
         $res = $res . " <button class='btn-small' onclick='showData(" . '"' . $question . '"' . ")' >Show data</button>";
        $res = $res . "<div id='$question' class='data'>";
        foreach($answers as $answer){
            $res = $res . "<p> $answer <a href='answers/files/". $id . "_" . $answer . "' download='". $answer . "' class='link'>Download file</a></p>";
        }
        $res = $res . "</div>";
    }
    else{
        $res = $res . " <button class='btn-small' onclick='showData(" . '"' . $question . '"' . ")' >Show data</button>";
        $res = $res . "<div id='$question' class='data'>";
        foreach($answers as $answer){
            $res = $res . "<p> $answer </p>";
        }
        $res = $res . "</div>";
    }
    
    $res = $res . "</div>";
    
    return $res;
}

function split_inputs_disabled($row){
    $row = explode(";",$row)[0];
    $res = '';
    $elements = explode(",",$row);
    $res = $res . "<div class='quest'><label class='title'>" .explode('=',$elements[0])[1] . "</label>";
    
    if(explode('=',$elements[1])[1] == "radio" || explode('=',$elements[1])[1]  == "checkbox"){
        
        
        $number_of_options = explode('=',$elements[2])[1];
        $name = explode('=',$elements[3])[1];
        $type = explode('=',$elements[1])[1];
        
        for($i=0;$i<$number_of_options;$i++){
            $label = explode('=',$elements[4 + $i*2])[1];
            $value = explode('=',$elements[5 + $i*2])[1];
            $res = $res . "<div class='multi'>";
            $res = $res . "<input disabled type='$type' class='$type' name='" . $name . "[]' label = '$label'  value = '$value'>";
            $res = $res . "<label class='radio_label'>$label</label> </div>";
            
        }
        $res = $res . "</div>";
    }
    
    else{
        
        $type = trim(explode('=',$elements[1])[1]);
        $res = $res . "<input disabled class='input' required ";
           foreach($elements as $element){
               $el = explode('=',$element);
               $res = $res . "$el[0]='" . trim($el[1]) . "'";
           }
        $res = $res . "> </div>";
       }
    
  return $res;
}

?>
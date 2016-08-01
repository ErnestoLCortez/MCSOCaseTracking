<?php

?>

<div>
<h2>Search for Cases</h2>
<table border=1>
<tr>
<th>Victim</th>
 </tr>  
<tr>
    <td>
<input type="text" name="victim" id="victim">
</td>
<td><div><button id="displayAll">Search</button></div></td>
<td><div><button id="reset">Reset</button></div></td>
</tr>
</table>

</div>
<div id="all">Results</div>

<script>
$("#displayAll").click(function(){
  $.ajax({
      "method": "GET",
      "url": "searchCasesCode.php",
      "data": {
          "victim": $("#victim").val(),
      },
      "success": function(data, status)
      {
          $("#all").html(data);
          $("#all").slideDown(0);
      }
  });
});
$("#reset").click(function(){
  $.ajax({
      "method": "GET",
      "url": "searchCasesCode.php",
      "data": {
          "victim": null,
      },
      "success": function(data, status)
      {
          $("#all").html(data);
          $("#all").slideDown(0);
      }
  });
});
</script>
<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            .inner table, .inner td{border:1px solid #ccc;}
        </style>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>
        $(document).ready(function(){
          $("#Lookup").click(function(){
            var sym = $("#sym").val();
            if(sym.trim() != ''){
                if ($('#btn').length > 0) {
                    $("#buysell").load("ajax.php?syms="+sym );
                }else{
                    $("#result").load("ajax.php?sym="+sym );
                }
            }
            else {
             alert('Please enter the symbol!');   
            }
          });
        });
        
        </script>
    </head>
    <body >
        
        <table style="width:100%" border="1" cellpadding="0" cellspacing="0">
            <tr>
              <th>Simple stock Exchange</th>
              <th>
                    <input type="text" name="sym" id="sym" />
                    <input type="button" name="btn" id="Lookup" value="Lookup"/>
              </th>
            </tr>
            <tr  id="result">
                <td height="40"></td>
                <td></td>
            </tr>
      </table>
        
    </body>
</html>
